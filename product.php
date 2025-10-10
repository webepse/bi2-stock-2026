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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
<body>
    <?php echo $don['name'] ?>
    <h1><?= $don['name'] ?></h1>
    <img src="images/<?= $don['cover'] ?>" alt="image de <?= $don['name'] ?>">
    <h4><?= $don['date'] ?></h4>
    <div><?= $don['description'] ?></div>
</body>
</html>