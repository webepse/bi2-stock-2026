<?php
    require "config/connexion.php";
?>

<!doctype html>
<html lang="fr">
<?php
    include("partials/head.php");
?>
<body>
<?php
    include("partials/nav.php");
?>
<div class="slide" id="home">
    <div id="hero">
        <h4>Subtitle</h4>
        <h1>Site Title</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad deleniti eveniet in optio pariatur perspiciatis rerum. Aliquam dolorum iure quaerat.</p>
        <a href="#" class="btn">En savoir plus</a>
    </div>
    <div id="social">social links</div>
</div>
<div class="slide" id="pres">
    <div class="gauche">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="images/images.jpg" alt="image">
                </div>
                <div class="swiper-slide">
                    <img src="images/Lion_d'Afrique.jpg" alt="image">
                </div>
                <div class="swiper-slide">
                    <img src="images/pap.jpg" alt="image">
                </div>
            </div>
        </div>
    </div>
    <div class="droite">
        <div class="container">
            <h2>Présentation</h2>
            <p><strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Adipisci delectus eum explicabo minima nisi recusandae velit? Aperiam, cum delectus fuga fugit hic laborum nam provident quidem. Dolorum excepturi facilis molestiae recusandae <strong>rem repellat reprehenderit</strong>. Aliquam enim eos esse et excepturi harum, quae quia sint sit voluptate? Architecto sapiente soluta ut!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci delectus eum explicabo minima nisi <strong>recusandae velit?</strong> Aperiam, cum delectus fuga fugit hic laborum nam provident quidem. Dolorum excepturi facilis molestiae recusandae <strong>rem repellat reprehenderit</strong>. Aliquam enim eos esse et excepturi harum, quae quia sint sit voluptate? Architecto sapiente soluta ut!</p>
            <div id="btn-video" class="btn">Voir vidéo</div>
            <h3>Skills</h3>
            <div id="skills">
                <?php
                    $skills = $bdd->query('SELECT * FROM skills');
                    while ($skill = $skills->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='skills'>";
                            echo "<img src='images/".$skill['image']."' alt='logo ".$skill['nom']."'>";
                            echo "<div class='title'>".$skill['nom']."</div>";
                        echo "</div>";
                    }
                    $skills->closeCursor();
                ?>
            </div>
        </div>
    </div>
    <div id="container-video">
        <div id="video-fond">
            <video src="images/scarface.mp4" muted controls></video>
        </div>
        <div id="close-video">Fermer</div>
    </div>
</div>
<div class="slide" id="galerie">
    <div class="container">
        <h2>Galerie</h2>

        <div id="container-gal">
            <?php
                $products = $bdd->query("SELECT products.cover AS cover, products.name AS pname, categories.name AS cname, DATE_FORMAT(products.date, '%d/%m/%Y') AS mydate, products.id AS pid, categories.id AS cid FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.date DESC LIMIT 0,6");
                while ($product = $products->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="images">';
                            echo '<img src="images/mini_'.$product['cover'].'" alt="image de '.$product['pname'].'">';
                            echo '<div class="info-gal">';
                                    echo "<a href='product.php?id=".$product['pid']."' class='title-gal'>".$product['pname']."</a>";
                                    echo "<a href='categories.php?id=".$product['cid']."' class='categorie-gal'>".$product['cname']."</a>";
                            echo '</div>';
                    echo '</div>';
                }
                $products->closeCursor();
            ?>
        </div>
        <a href="categories.php" class="btn btn-primary">Voir plus</a>
    </div>
</div>
<div class="slide" id="contact">
    <div id="container">
        <div class="wrapper">
            <div class="gauche">
                <h3>Get in touch</h3>
                <div class="title-contact"><img src="images/tel.svg" alt="tel">Call us</div>
                <div class="info-contact">02 / 01 02 03</div>
                <div class="title-contact"><img src="images/location.svg" alt="location">Location</div>
                <div class="info-contact">Rue du village 50 7850 Enghien</div>
                <div class="title-contact"><img src="images/time.svg" alt="time">Business Hours</div>
                <div class="info-contact">8h30 - 16h</div>
            </div>
            <div class="droite">
                <form action="treatmentContact.php" method="POST">
                    <h3>Contact Us</h3>
                    <?php
                        if(isset($_GET['success']))
                        {
                            echo "<div class='success'>Merci pour votre message</div>";
                        }
                        if(isset($_GET['error']))
                        {
                            echo "<div class='error'>Veuillez remplir correctement le formulaire</div>";
                        }
                    ?>
                    <input type="text" name="nom" id="nom" placeholder="Name" required>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <textarea name="message" id="message"  placeholder="Message" required></textarea>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    include("partials/footer.php");
?>
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

    // pour la vidéo
    const btnVideo = document.querySelector("#btn-video");
    const containerVideo = document.querySelector("#container-video");
    const closeVideo = document.querySelector("#close-video");
    const video  = document.querySelector("#video-fond video");

    btnVideo.addEventListener("click",()=>{
        containerVideo.classList.toggle("open");
        video.play();
    });

    closeVideo.addEventListener("click",()=>{
        containerVideo.classList.remove("open");
        video.pause();
    });

</script>
</body>
</html>