<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
        exit();
    }

    // besoin de la bdd
    require "../config/connexion.php";

    if(isset($_GET['delete']) && is_numeric($_GET['delete']))
    {
        $id = htmlspecialchars($_GET['delete']);
        $products = $bdd->prepare("SELECT * FROM products WHERE category=?");
        $products->execute([$id]);
        while($donProd = $products->fetch())
        {
            unlink("../images/".$donProd['cover']);
            unlink("../images/mini_".$donProd['cover']);
            // chercher les images associées
            $galImg = $bdd->prepare("SELECT * FROM images WHERE id_product=?");
            $galImg->execute([$donProd['id']]);
            while($donGal = $galImg->fetch())
            {
                unlink("../images/".$donGal['fichier']);
            }
            $galImg->closeCursor();
            // supprimer les données
            $delGal = $bdd->prepare("DELETE FROM images WHERE id_product=?");
            $delGal->execute([$donProd['id']]);
        }
        $products->closeCursor();

        // supprimer les données produits
        $delProd = $bdd->prepare("DELETE FROM products WHERE category=?");
        $delProd->execute([$id]);
        
        // supprimer categorie
        $delCat = $bdd->prepare("DELETE FROM categories WHERE id=?");
        $delCat->execute([$id]);

        header("LOCATION:categories.php?successdel=".$id);
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
    <title>Stock - Administration - Gestion des catégories</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container-fluid">
        <h1>Gestion des catégories</h1>
        <a href="addCategory.php" class="btn btn-primary my-2">Ajouter une catégorie</a>
        <?php
            if(isset($_GET['add']) && $_GET['add']=="success")
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une nouvelle catégorie à la base de données</div>";
            }
            if(isset($_GET['update']) && is_numeric($_GET['update']))
            {
                 echo "<div class='alert alert-warning'>Vous avez bien modifié la catégorie n°".$_GET['update']." à la base de données</div>";
            }
        ?>
        <table class="table table-striped">

            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                  
                    $categories = $bdd->query("SELECT * FROM categories");
                    while($donCat = $categories->fetch())
                    {
                        echo '<tr class="text-center">';
                            echo '<td>'.$donCat['id'].'</td>';
                            echo '<td>'.$donCat['name'].'</td>';
                            echo '<td>';
                                echo '<a href="updateCategory.php?id='.$donCat['id'].'" class="btn btn-warning">Modifier</a>';
                                echo '<button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal'.$donCat['id'].'">
  supprimer
</button>';
                            echo '<div class="modal fade" id="deleteModal'.$donCat['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel'.$donCat['id'].'" aria-hidden="true">';
                                echo '<div class="modal-dialog">';
                                    echo '<div class="modal-content">';
                                        echo ' <div class="modal-header">';
                                        echo '<h1 class="modal-title fs-5" id="exampleModalLabel'.$donCat['id'].'">Supprimer #'.$donCat['id'].'</h1>';
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                    echo ' </div>';
                                        echo ' <div class="modal-body">';
                                            echo 'Voulez-vous vraiment supprimer le produit: "'.$donCat['name'].'" ?';;
                                        echo '</div>';
                                        echo ' <div class="modal-footer">';
                                            echo ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne pas supprimer</button>';
                                            echo '<a href="categories.php?delete='.$donCat['id'].'" class="btn btn-danger mx-2">Supprimer</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';

                            echo '</td>';
                        echo '</tr>';
                    }
                    // à cause du système de cursor et qu'on boucle plusieurs fois, on doit close le cursor
                    $categories->closeCursor();
                ?>
            </tbody>

        </table>

    </div>
</body>
</html>