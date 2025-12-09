<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
    exit();
}

// besoin de la bdd
require "../config/connexion.php";

if(isset($_GET['delete']) && is_numeric($_GET['delete']))
{
   $id = htmlspecialchars($_GET['delete']);
   $verif = $bdd->prepare("SELECt * FROM contact WHERE id=?");
   $verif->execute([$id]);
   $don = $verif->fetch();
   if(!$don)
   {
       header("LOCATION:contact.php");
       exit();
   }
   $sup = $bdd->prepare("DELETE FROM contact WHERE id=?");
   $sup->execute([$id]);
   header("LOCATION:contact.php?successdelete=".$id);
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
<div class="container-fluid">
    <h1>Gestion des contact</h1>
    <?php
        if(isset($_GET['successdelete']) && is_numeric($_GET['successdelete']))
        {
            echo "<div class='alert alert-danger my-2'>Vous avez bien supprimé le message #".$_GET['successdelete']."</div>";
        }

    ?>

    <table class="table table-striped">

        <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Nom</th>
            <th>E-mail</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $req = $bdd->query("SELECT id, nom, email, DATE_FORMAT(date,'%d/%m/%Y %Hh%i') AS mydate FROM contact");
            while($don = $req->fetch())
            {
                echo "<tr class='text-center'>";
                    echo "<td>".$don['id']."</td>";
                    echo "<td>".$don['nom']."</td>";
                    echo "<td>".$don['email']."</td>";
                    echo "<td>".$don['mydate']."</td>";
                    echo "<td>";
                        echo "<a href='viewContact.php?id=".$don['id']."' class='btn btn-primary'>Voir</a>";
                        echo "<a href='contact.php?delete=".$don['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                    echo "</td>";
                echo "</tr>";
            }
            $req->closeCursor();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>