<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
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
            // insertion dans la base de données
            require "../config/connexion.php";
            $insert = $bdd->prepare("INSERT INTO categories(name) VALUES(?)");
            $insert->execute([$nom]);
            // redirection vers la page categories.php avec indication du success
            header("LOCATION:categories.php?add=success");
            exit();
        }else{
            // il y a une erreur dans le formulaire
            // redirection vers la page formulaire avec indication de l'erreur
            header("LOCATION:addCategory.php?error=".$err);
            exit();
        }


    }else{
        // formulaire pas envoyé donc redirection
        header("LOCATION:addCategory.php");
        exit();
    }
?>