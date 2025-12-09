<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
    exit();
}

// besoin de la bdd
require "../config/connexion.php";

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
}
else{
    header("LOCATION:contact.php");
    exit();
}

// vérifier si l'id existe dans la bdd
$verif = $bdd->prepare("SELECT id, nom, email, DATE_FORMAT(date,'%d/%m/%Y %Hh%i') AS mydate, message FROM contact WHERE id=?");
$verif->execute([$id]);
$donVerif = $verif->fetch();
if(!$donVerif)
{
    header("LOCATION:../404.php");
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
    <title>Stock - Administration - Gestion des contact</title>
</head>
<body>
<?php
include("partials/nav.php");
?>
<div class="container">
    <a href="contact.php" class="btn btn-secondary my-3">Retour</a>
    <div class="row">
        <div class="col-md-6 py-5"">
            <h1>Message de <?= $donVerif['nom'] ?></h1>
            <h4>Envoyé le : <?= $donVerif['mydate'] ?></h4>
            <h3>Email: <?= $donVerif['email'] ?></h3>
            <hr>
            <a href="mailto:<?= $donVerif['email'] ?>" class="btn btn-success">Répondre</a>
        </div>
        <div class="col-md-6 py-5">
            <h3>Message</h3>
            <hr>
            <?= nl2br($donVerif['message']) ?>
        </div>
    </div>
</div>
</body>
</html>