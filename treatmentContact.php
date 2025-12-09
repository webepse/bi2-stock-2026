<?php

if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['message']))
{
    $err = 0;
    if(empty($_POST['nom']))
    {
        $err = 1;
    }else{
        $nom = htmlspecialchars(strip_tags($_POST['nom']));
    }

    if(empty($_POST['email']))
    {
        $err = 2;
    }else{
        $email = htmlspecialchars(strip_tags($_POST['email']));
    }

    if(empty($_POST['message']))
    {
        $err = 3;
    }else{
        $message = htmlspecialchars(strip_tags($_POST['message']));
    }

    if($err == 0)
    {
        require "config/connexion.php";
        $insert = $bdd->prepare("INSERT INTO contact(nom, email, message, date) VALUES(:nom,:email,:message,NOW())");
        $insert->execute([
            ":nom" => $nom,
            ":email" => $email,
            ":message" => $message
        ]);
        header("LOCATION:index.php?success=1#contact");
        exit();
    }else{
        header("LOCATION:index.php?error=".$err."#contact");
        exit();
    }

}else{
    header("LOCATION:404.php");
    exit();
}