<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
        exit();
    }

    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
        require "../config/connexion.php";
        $req = $bdd->prepare("SELECT * FROM categories WHERE id=?");
        $req->execute([$id]);
        $don = $req->fetch();
        if(!$don)
        {
            header("LOCATION:../404.php");
            exit();
        }
    }else{
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
    <title>Stock - Administration - modifier une catégorie</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container-fluid">
        <h1>Modifier une catégorie</h1>
        <a href="categories.php" class="btn btn-secondary my-2">Retour</a>
        <div class="container">
            <form action="treatmentUpdateCategory.php?id=<?= $don['id'] ?>" method="POST">
                <?php
                    if(isset($_GET['error']))
                    {
                        echo "<div class='alert alert-danger'>Une erreur est survenue (code erreur: ".$_GET['error'].")</div>";
                    }
                ?>
                <div class="form-group my-3">
                    <label for="nom">Nom de la catégorie</label>

                    <input type="text" id="nom" name="nom" class="form-control" value="<?= $don['name'] ?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="Modifier" class="btn btn-warning">
                </div>
            </form>
        </div>
    </div>
</body>
</html>