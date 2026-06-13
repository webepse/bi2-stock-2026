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
    <?php include("partials/head.php"); ?>
</head>
<body>
<?php
    include("partials/nav.php");
?>
<div class="slide" id="categories">

    <div class="container">
        <h1>Les catégories <?php if($mode!="all"){ echo " - ".$donSecu['name'];} ?></h1>
        <div id="cat-container">
            <a href="categories.php" class="btn btn-primary">Tous</a>
            <?php
                $catList = $bdd->query("SELECT * FROM categories");
                while($donCatList = $catList->fetch())
                {
                    echo "<a href='categories.php?id=".$donCatList['id']."' class='btn btn-primary mx-2'>".$donCatList['name']."</a>";
                }
                $catList->closeCursor();
            ?>
        </div>
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
                echo "<div class='card-container'>";
                while($don = $req->fetch())
                {
                        echo '<div class="card my-3">';
                            echo '<img src="images/mini_'.$don['cover'].'" class="card-img-top" alt="image de '.$don['pname'].'">';
                            echo ' <div class="card-body">';
                                echo '<h5 class="card-title">'.$don['pname'].'</h5>';
                                echo '<a href="categories.php?id='.$don['cid'].'" class="btn btn-secondary">'.$don['cname'].'</a>';
                                echo ' <p class="card-text"><strong>Date: </strong>'.$don['mydate'].'</p>';
                                echo ' <a href="product.php?id='.$don['pid'].'" class="btn btn-primary">En savoir plus</a>';
                            echo '</div>';
                        echo '</div>';
                }
                echo "</div>";
            }else{
                // si pas supérieur à 0 => afficher un message
                echo "<p class='zero'>Aucun produit dans cette catégorie</p>";
            }
            // fermeture du curseur de la base de données
            $req->closeCursor();
            ?>
        </div>

    </div>
</div>
<?php include("partials/footer.php"); ?>
<script>
    const burger = document.querySelector("#burger");
    const menuMobile = document.querySelector("#menu-mobile");
    // select links (retourne un tableau - array)
    const links = document.querySelectorAll("#menu-mobile nav ul li a");

    // fonction flechée () => {}
    burger.addEventListener("click",()=>{
        burger.classList.toggle("open");
        menuMobile.classList.toggle("open");
    });

    // boucler/parcourir le tableau link
    for(let link of links){
        link.addEventListener("click",()=>{
            burger.classList.remove("open");
            menuMobile.classList.remove("open");
        })
    }
</script>
</body>
</html>