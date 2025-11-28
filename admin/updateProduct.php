<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
    exit();
}


// vérifier la dépendance du fonctionnement de ma page, elle a besoin de l'id (de modifier qui?)
// si id n'existe pas ET si id n'est pas un nombre alors on redirige vers la page products.php
if(!isset($_GET['id']) && !is_numeric($_GET['id']))
{
    header("LOCATION:products.php");
    exit();
}else // sinon on continue
{
    // proctection de l'id pour son utilisation dans la bdd
    $id = htmlspecialchars($_GET['id']);
}

// besoin de la bdd pour récupèrer les informations du produit que l'on vont modifier
require "../config/connexion.php";
// req à la bdd -> qui à une inconnue
$req = $bdd->prepare("SELECT * FROM products WHERE id=?");
$req->execute([$id]);
// je sais que je ne vais avoir qu'une réponse (pas plusieurs puisque mon id est unique)
$don = $req->fetch(PDO::FETCH_ASSOC);
// m'assurer que $don à bien une valeur
//var_dump($don);
// est-ce que $don retourne false ? (grace au ! que la question est en mode négation)
if(!$don)
{
    header("LOCATION:products.php");
    exit();
}
// $req->closeCursor(); // => pas obligatoire car on fait que un fetch

//var_dump($don['name'])


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
    <h1>Modifier le produit: <?= $don['name'] ?></h1>
    <a href="products.php" class="btn btn-secondary my-2">Retour</a>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="treatmentUpdateProduct.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
                    <?php
                    // isset => si existe
                    // si tu vois dans l'URL ?error=123 alors c'est que tu as une erreur
                    if(isset($_GET['error']))
                    {
                        // alors j'affiche un message d'erreur
                        echo "<div class='alert alert-danger'>Une erreur est survenue (code erreur: ".$_GET['error'].")</div>";
                    }

                    if(isset($_GET['errorImg']))
                    {
                        echo "<div class='alert alert-danger'>Une erreur est survenue au niveau de l'image(code erreur: ".$_GET['errorImg'].")</div>";
                    }
                    ?>
                    <div class="form-group my-3">
                        <label for="nom">Nom du produit</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= $don['name'] ?>">
                    </div>
                    <div class="form-group my-3">
                        <label for="date">date</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?= $don['date'] ?>">
                    </div>
                    <div class="form-group my-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control"><?= $don['description'] ?></textarea>
                    </div>
                    <div class="form-group my-3">
                        <label for="cover">Image de couverture</label>
                        <div class="col-md-4 my-3">
                            <img src="../images/<?= $don['cover'] ?>" alt="image de couverture" class="img-fluid">
                        </div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                        <input type="file" id="cover" name="cover" class="form-control">
                    </div>
                    <div class="form-group my-3">
                        <label for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie" class="form-control">
                            <?php
                            require "../config/connexion.php";
                            $reqCat = $bdd->query("SELECT * FROM categories");
                            while($donCat = $reqCat->fetch())
                            {
                                // si correspondance j'utilise l'attribut selected
                                if($don['category'] == $donCat['id'])
                                {
                                    echo "<option value='".$donCat['id']."' selected>".$donCat['name']."</option>";
                                }else{
                                    echo "<option value='".$donCat['id']."'>".$donCat['name']."</option>";
                                }
                            }
                            $reqCat->closeCursor();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Modifier" class="btn btn-warning">
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <!-- gestion des images associées -->
                 <h2>Gestion des images</h2>
                 <a href="addImg.php?id=<?= $id ?>" class="btn btn-primary my-3">Ajouter une image</a>
                 <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                            $galery = $bdd->prepare("SELECT * FROM images WHERE id_product=?");
                            $galery->execute([$id]);
                            while($donGal = $galery->fetch())
                            {
                                echo "<tr>";
                                    echo "<td>".$donGal['id']."</td>";
                                    echo "<td><img src='../images/".$donGal['fichier']."' alt='image de ".$don['name']."' class='img-fluid col-3'></td>";
                                    echo "<td><a href='#' class='btn btn-danger'>Supprimer</a></td>";
                                echo "</tr>";
                            }
                            $galery->closeCursor();
                        ?>
                    </tbody>
                 </table>
            </div>
        </div>
        
    </div>
</div>
</body>
</html>

