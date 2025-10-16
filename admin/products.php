<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
        exit();
    }

    // besoin de la bdd
    require "../config/connexion.php";
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
                    $products = $bdd->query("SELECT id, name, category, DATE_FORMAT(date,'%d / %m / %Y') AS mydate FROM products");
                    while($donProd = $products->fetch())
                    {
                        echo '<tr class="text-center">';
                            echo '<td>'.$donProd['id'].'</td>';
                            echo '<td>'.$donProd['name'].'</td>';
                            echo '<td>'.$donProd['mydate'].'</td>';
                            echo '<td>'.$donProd['category'].'</td>';
                            echo '<td>';
                                echo '<a href="#" class="btn btn-warning">Modifier</a>';
                                echo '<a href="#" class="btn btn-danger mx-2">Supprimer</a>';
                            echo '</td>';
                        echo '</tr>';
                    }
                    // à cause du système de cursor et qu'on boucle plusieurs fois, on doit close le cursor
                    $products->closeCursor();
                ?>
            </tbody>

        </table>

    </div>
</body>
</html>