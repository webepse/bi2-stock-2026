<?php
    require "config/connexion.php";
    // mode = filtre

    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        // l'utilisateur a choisi un filtre
        $mode = htmlspecialchars($_GET['id']);
        // sécurité, l'id est bien lié à une catégorie existante
        // requête de sécurité
        $reqSecu = $bdd->prepare("SELECT * FROM categories WHERE id=?");
        $reqSecu->execute([$mode]);
        $donSecu = $reqSecu->fetch(PDO::FETCH_ASSOC);
        if(!$donSecu)
        {
            header("LOCATION:404.php");
            exit();
        }
    }else{
        // aucun filtre
        $mode = "all";
    }




?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="build/style.css">
    <title>Catégories</title>
</head>
<body>
<?php
    include("partials/nav.php");
?>
    <div class="container">
        <h1>Les catégories</h1>
        <a href="categories.php" class="btn btn-secondary">Tous</a>
        <?php
            $catList = $bdd->query("SELECT * FROM categories");
            while($donCatList = $catList->fetch())
            {
                echo "<a href='categories.php?id=".$donCatList['id']."' class='btn btn-primary mx-2'>".$donCatList['name']."</a>";
            }
            $catList->closeCursor();
        ?>
        <div class="row">
            <?php
            require "config/connexion.php";
            // choix du type de requête suivant le choix du filtre de l'utilisateur
            if($mode == "all")
            {
                $req = $bdd->query("SELECT products.cover AS cover, products.name AS pname, categories.name AS cname, DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.date DESC");
            }else{
                $req = $bdd->prepare("SELECT products.cover AS cover, products.name AS pname, categories.name AS cname, DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid FROM products INNER JOIN categories ON products.category = categories.id WHERE products.category=? ORDER BY products.date DESC");
                $req->execute([$mode]);
            }
            // compter le nombre de résultats
            $count = $req->rowCount();
            // si supérieur à 0 => boucle qui affiche les produits
            if($count > 0)
            {
                while($don = $req->fetch())
                {
                    echo '<div class="col-lg-3 col-md-4 col-sm-6">';
                        echo '<div class="card my-3">';
                            echo '<img src="images/mini_'.$don['cover'].'" class="card-img-top" alt="image de '.$don['pname'].'">';
                            echo ' <div class="card-body">';
                                echo '<h5 class="card-title">'.$don['pname'].'</h5>';
                                echo '<a href="categories.php?id='.$don['cid'].'" class="btn btn-secondary">'.$don['cname'].'</a>';
                                echo ' <p class="card-text"><strong>Date: </strong>'.$don['mydate'].'</p>';
                                echo ' <a href="product.php?id='.$don['pid'].'" class="btn btn-primary">En savoir plus</a>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }else{
                // si pas supérieur à 0 => afficher un message
                echo "<p class='col-12 text-center'>Aucun produit dans cette catégorie</p>";
            }
            // fermeture du curseur de la base de données
            $req->closeCursor();
            ?>
        </div>

    </div>
</body>
</html>