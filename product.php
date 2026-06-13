<?php
    // tester la présence de id dans l'url
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        // protèger la valeur
        $id = htmlspecialchars($_GET['id']);
    }// sinon
    else{
        // redirection vers 404
        header("LOCATION:404.php");
        exit();
    }

    require "config/connexion.php";

    // req à la bdd pour vérifier si l'id existe et même temps récup les infos
    $req = $bdd->prepare("SELECT * FROM products WHERE id=?");
    //$req = $bdd->query("SELECT * FROM products WHERE id=25");
    $req->execute([$id]);
    // si id=25 => SELECT * FROM products WHERE id=25
    // récup les données
    $don = $req->fetch();

    // vérifier si j'ai bien des données
    if(!$don)
    {
        header("LOCATION:404.php");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
   <?php include("partials/head.php"); ?>
</head>
<body>
<?php
    include("partials/nav.php");
?>
<div class="slide" id="product">
    <a href="categories.php" class="btn btn-primary">Les catégories</a>
    <div class="row">
        <div class="gauche">
            <img src="images/<?= $don['cover'] ?>" alt="image de <?= $don['name'] ?>" class="img-fluid">
        </div>
        <div class="droite">
            <div class="texte">
                <h1><?= $don['name'] ?></h1>
                <h4><?= $don['date'] ?></h4>
                <div><?= $don['description'] ?></div>
                <div id="product-galerie">
                    <h4>Galerie d'image</h4>
                    <?php
                            $galerie = $bdd->prepare("SELECT * FROM images WHERE id_product=?");
                            $galerie->execute([$id]);
                            $count = $galerie->rowCount();
                            if($count > 0)
                            {
                                echo ' <div class="swiper mySwiper">';
                                    echo '<div class="swiper-wrapper">';
                                        while($donGal = $galerie->fetch())
                                        {
                                            echo '<div class="swiper-slide">';
                                                echo "<img src='images/".$donGal['fichier']."' alt='image de galere de".$don['name']."'>";
                                            echo "</div>";
                                        }
                                    echo "</div>";
                                echo "</div>";
                            }
                            else{
                                echo "<p>Aucune image pour le moment</p>";
                            }
                            $galerie->closeCursor();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("partials/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        }
    });

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