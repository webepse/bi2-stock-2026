<?php
    require "config/connexion.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Stock</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <!-- contenu du site -->

    <?php
        $req = $bdd->query("SELECT * FROM products ORDER BY date DESC LIMIT 2");
        while($don = $req->fetch())
        {
           // echo "<div>".$don['name']."</div>";
           echo "<div>";
                echo "<a href='product.php?id=".$don['id']."'>".$don['name']."</a>";
                // echo "<a href='product.php?id='></a>";
                // echo "<a href='product.php?id=".."'>".."</a>";
           echo "</div>";
        }
        $req->closeCursor();
    ?>


    <?php
        include("partials/footer.php");
    ?>
</body>
</html>