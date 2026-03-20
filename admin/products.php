<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
        exit();
    }

    // besoin de la bdd
    require "../config/connexion.php";
    // pour calculer l'offset de l'info dans l'url
    // récup page dans l'url
    // intérroger la bdd pour savoir combien j'ai besoin de page
    $reqPage = $bdd->query("SELECT * FROM products");
    $count = $reqPage->rowCount();
    $limit= 5;
    // 41 
    // limit de 10
    // 41/10 = 4.1
    $nbPage = ceil($count/$limit);
    if(isset($_GET['page']))
    {
        // sécurité
        // pour savoir si une valeur est numérique => is_numeric()
        if(is_numeric($_GET['page']))
        {
            if($_GET['page']>$nbPage)
            {
                $pg = $nbPage;
            }elseif($_GET['page'] <=0)
            {
                $pg = 1;
            }else{
                $pg = htmlspecialchars($_GET['page']);
            }
        }else{
            header("LOCATION:404.php");
            exit();
        }
    }else{
        $pg=1;
    }

    // (1-1)*10=0
    // (2-1)*10=10
    // (3-1)*10=20 
    $offset = ($pg-1)*$limit;
 
 

    // vérifier si dans l'url de la page il y a un GET delete ($_GET['delete']) => GET = ?delete=7
    // localhost/PHP/bi2-stock-2026/admin/products.php?delete=7
    // is_numeric(7) => true ou false => si c'est un nombre alors true sinon false
    if(isset($_GET['delete']) && is_numeric($_GET['delete']))
    {
        // protection de l'id surtout quand on va utiliser la donnée la bdd
        $id = htmlspecialchars($_GET['delete']); // &copy;
        // vérifier si l'id existe dans la bdd
        $verif = $bdd->prepare("SELECT * FROM products WHERE id=?");
        $verif->execute([$id]);
        $donVerif = $verif->fetch();
        if(!$donVerif)
        {
            header("LOCATION:products.php");
            exit();
        }

        // supprimer l'image
        unlink("../images/".$donVerif['cover']);
        unlink("../images/mini_".$donVerif['cover']);

        // supprimer la galerie image
        // rechercher les images
        $searchGal = $bdd->prepare("SELECT * FROM images WHERE id_product=?");
        $searchGal->execute([$id]);
        while($donGal = $searchGal->fetch())
        {
            unlink("../images/".$donGal['fichier']);
        }
        $searchGal->closeCursor();

        // supprimer dans la bdd les données
        $deGal = $bdd->prepare("DELETE FROM images WHERE id_product=?");
        $deGal->execute([$id]);


        // supprimer le produit
        $supprimer = $bdd->prepare("DELETE FROM products WHERE id=?");
        $supprimer->execute([$id]);

        // redirection vers la page products.php avec indication du success de la suppression
        header("LOCATION:products.php?successdelete=".$id);
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Stock - Administration - Gestion des produits</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container-fluid">
        <h1>Gestion des produits</h1>
        <a href="addProduct.php" class="btn btn-primary my-2">Ajouter un produit</a>
        <?php
            if(isset($_GET['add']) && $_GET['add']=="success")
            {
                echo "<div class='alert alert-success my-2'>Vous avez bien ajouté un nouveau produit à la base de données</div>";
            }

            if(isset($_GET['update']) && is_numeric($_GET['update']))
            {
                echo "<div class='alert alert-warning my-2'>Vous avez bien modifié le produit #".$_GET['update']."</div>";
            }

            if(isset($_GET['successdelete']) && is_numeric($_GET['successdelete']))
            {
                echo "<div class='alert alert-danger my-2'>Vous avez bien supprimé le produit #".$_GET['successdelete']."</div>";
            }

        ?>

        <table class="table table-striped">

            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Catégorie</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    // DATE_FORMAT(champs,'format de la date')
                    // %d = jour
                    // %m = mois
                    // %Y = année (4 chiffres)
                    // AS -> crée un alias pour la donnée
                    $products = $bdd->prepare("SELECT id, name, category, DATE_FORMAT(date,'%d / %m / %Y') AS mydate FROM products LIMIT :offset,:limit");
                    $products->bindParam(":offset",$offset, PDO::PARAM_INT);
                    $products->bindParam(":limit",$limit, PDO::PARAM_INT);
                    $products->execute();
                    while($donProd = $products->fetch())
                    {
                        echo '<tr class="text-center">';
                            echo '<td>'.$donProd['id'].'</td>';
                            echo '<td>'.$donProd['name'].'</td>';
                            echo '<td>'.$donProd['mydate'].'</td>';
                            echo '<td>'.$donProd['category'].'</td>';
                            echo '<td>';
                                echo '<a href="updateProduct.php?id='.$donProd['id'].'" class="btn btn-warning">Modifier</a>';

                                echo '<button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal'.$donProd['id'].'">
  supprimer
</button>';
                            echo '<div class="modal fade" id="deleteModal'.$donProd['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel'.$donProd['id'].'" aria-hidden="true">';
                                echo '<div class="modal-dialog">';
                                    echo '<div class="modal-content">';
                                        echo ' <div class="modal-header">';
                                        echo '<h1 class="modal-title fs-5" id="exampleModalLabel'.$donProd['id'].'">Supprimer #'.$donProd['id'].'</h1>';
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                    echo ' </div>';
                                        echo ' <div class="modal-body">';
                                            echo 'Voulez-vous vraiment supprimer le produit: "'.$donProd['name'].'" ?';;
                                        echo '</div>';
                                        echo ' <div class="modal-footer">';
                                            echo ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne pas supprimer</button>';
                                            echo '<a href="products.php?delete='.$donProd['id'].'" class="btn btn-danger mx-2">Supprimer</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            echo '</td>';
                        echo '</tr>';
                    }
                    // à cause du système de cursor et qu'on boucle plusieurs fois, on doit close le cursor
                    $products->closeCursor();
                ?>
            </tbody>

        </table>

        <nav class="d-flex justify-content-center my-5">
            <ul class="pagination">
                <?php
                    if($pg>1)
                    {
                        echo '<li class="page-item"><a href="products.php?page='.($pg-1).'" class="page-link">Previous</a></li>';
                    }

                    for($i=1;$i<=$nbPage;$i++)
                    {
                        if($pg==$i)
                        {   
                            echo '<li class="page-item active"><a class="page-link" href="products.php?page='.$i.'">'.$i.'</a></li>';

                        }else{
                            echo '<li class="page-item"><a class="page-link" href="products.php?page='.$i.'">'.$i.'</a></li>';
                        }
                    }

                    if($pg!=$nbPage)
                    {
                        echo '<li class="page-item"><a class="page-link" href="products.php?page='.($pg+1).'">Next</a></li>';
                    }
                ?>   
            </ul>
        </nav>

    </div>
</body>
</html>

















