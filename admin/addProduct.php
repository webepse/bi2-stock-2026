<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
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
    <title>Stock - Administration - Ajouter un produit</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container-fluid">
        <h1>Ajouter un produit</h1>
        <a href="products.php" class="btn btn-secondary my-2">Retour</a>
        <div class="container">
            <form action="treatmentAddProduct.php" method="POST">
                <?php
                    if(isset($_GET['error']))
                    {
                        echo "<div class='alert alert-danger'>Une erreur est survenue (code erreur: ".$_GET['error'].")</div>";
                    }
                ?>
                <div class="form-group my-3">
                    <label for="nom">Nom du produit</label>
                    <input type="text" id="nom" name="nom" class="form-control">
                </div>
                <div class="form-group my-3">
                    <label for="date">date</label>
                    <input type="date" id="date" name="date" class="form-control">
                </div>
                <div class="form-group my-3">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group my-3">
                    <label for="cover">Image de couverture</label>
                    <input type="text" id="cover" name="cover" class="form-control">
                </div>
                <div class="form-group my-3">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-control">
                       <?php
                            require "../config/connexion.php";
                            $req = $bdd->query("SELECT * FROM categories");
                            while($don = $req->fetch())
                            {
                                echo "<option value='".$don['id']."'>".$don['name']."</option>";
                            }
                            $req->closeCursor();
                       ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Ajouter" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</body>
</html>