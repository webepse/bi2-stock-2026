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


    // vérification de l'envoie du formulaire
    if(isset($_POST['nom']))
    {
        // traitement de ou des donnée(s)
        // technique du $err = 0
        // init une variable erreur à 0
        $err = 0;

        // si un test se passe mal, on modifie la variable $err avec un nombre (permet le débug)
        if(empty($_POST['nom']))
        {
            $err = 1;
        }else{
            // protection de la donnée
            $nom = htmlspecialchars($_POST['nom']);
        }

        // fini les tests
        // vérification de la note de $err
        if($err == 0)
        {
            // update dans la base de données
            $update = $bdd->prepare("UPDATE categories SET name=? WHERE id=?");
            $update->execute([$nom,$id]);
            // redirection vers la page categories.php avec indication du success
            header("LOCATION:categories.php?update=success");
            exit();
        }else{
            // il y a une erreur dans le formulaire
            // redirection vers la page formulaire avec indication de l'erreur
            header("LOCATION:updateCategory.php?id=".$id."&error=".$err);
            exit();
        }
    }else{
        // formulaire pas envoyé donc redirection
        header("LOCATION:updateCategory.php?id=".$id);
        exit();
    }
?>