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
        $id = $_GET['delete'];
        // vérifier si l'id existe bien dans la bdd
        $verif = $bdd->prepare("SELECT * FROM skills WHERE id=?");
        $verif->execute([$id]);
        $don = $verif->fetch();
        if(!$don)
        {
            header("LOCATION:skills.php");
            exit();
        }

        //supprimer le fichier image
        unlink('../images/'.$don['image']);

        $del = $bdd->prepare("DELETE FROM skills WHERE id=?");
        $del->execute([$id]);
        header("LOCATION:skills.php?delsuccess=".$id);
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
    <title>Stock - Administration - Gestion des compétences</title>
</head>
<body>
    <?php
        include("partials/nav.php");
    ?>
    <div class="container-fluid">
        <h1>Gestion des compétences</h1>
        <a href="addSkills.php" class="btn btn-primary my-2">Ajouter une compétence</a>
        <?php
            if(isset($_GET['add']) && $_GET['add']=="success")
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une nouvelle compétence à la base de données</div>";
            }
            if(isset($_GET['update']) && is_numeric($_GET['update']))
            {
                 echo "<div class='alert alert-warning'>Vous avez bien modifié la compétence n°".$_GET['update']." à la base de données</div>";
            }
            if(isset($_GET['delsuccess']) && is_numeric($_GET['delsuccess']))
            {
                 echo "<div class='alert alert-danger'>Vous avez bien supprimé la compétence n°".$_GET['delsuccess']." à la base de données</div>";
            }
        ?>
        <table class="table table-striped">

            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                  
                    $skills = $bdd->query("SELECT * FROM skills");
                    while($donSkill = $skills->fetch())
                    {
                        echo '<tr class="text-center">';
                            echo '<td>'.$donSkill['id'].'</td>';
                            echo '<td>'.$donSkill['nom'].'</td>';
                            echo '<td>';
                                echo '<button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal'.$donSkill['id'].'">
  supprimer
</button>';
                            echo '<div class="modal fade" id="deleteModal'.$donSkill['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel'.$donSkill['id'].'" aria-hidden="true">';
                                echo '<div class="modal-dialog">';
                                    echo '<div class="modal-content">';
                                        echo ' <div class="modal-header">';
                                        echo '<h1 class="modal-title fs-5" id="exampleModalLabel'.$donSkill['id'].'">Supprimer #'.$donSkill['id'].'</h1>';
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                    echo ' </div>';
                                        echo ' <div class="modal-body">';
                                            echo 'Voulez-vous vraiment supprimer la compétence: "'.$donSkill['nom'].'" ?';;
                                        echo '</div>';
                                        echo ' <div class="modal-footer">';
                                            echo ' <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne pas supprimer</button>';
                                            echo '<a href="skills.php?delete='.$donSkill['id'].'" class="btn btn-danger mx-2">Supprimer</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';

                            echo '</td>';
                        echo '</tr>';
                    }
                    // à cause du système de cursor et qu'on boucle plusieurs fois, on doit close le cursor
                    $skills->closeCursor();
                ?>
            </tbody>

        </table>

    </div>
</body>
</html>