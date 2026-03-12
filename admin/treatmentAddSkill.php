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
            // gestion de l'image
            if($_FILES['image']['error']==0)
            {
                // récup des infos de l'image (nom, extension, type, taille)
                $nomImage = basename($_FILES['image']['name']);
                $extension = strrchr($_FILES['image']['name'],'.');
                $mimeType = $_FILES['image']['type'];
                $size = filesize($_FILES['image']['tmp_name']);

                // le dossier de destination (attention au dernier /)
                $dossier = "../images/";
                // initialisation de $errImg à 0 (pas d'erreur)
                $errImg = 0;

                // vérification des données de l'image
                // vérification de l'extension
                //création d'un tableau des extensions acceptées
                $extensionsAcceptees = ['.jpg','.jpeg','.png','.svg'];
                // in_array vérifie si l'extension ($extension) est dans le tableau ($extensionsAcceptees)
                // ! => négation (si l'extension n'est pas dans le tableau, alors on peut pas l'uploader => $erreur)
                if(!in_array($extension,$extensionsAcceptees))
                {
                    $errImg = 5;
                }

                // vérification du type MIME (type de fichier)
                $mimeTypesAcceptes = ['image/jpeg','image/jpg','image/png','image/svg+xml'];
                if(!in_array($mimeType,$mimeTypesAcceptes))
                {
                    $errImg = 6;
                }

                // vérification de la taille de l'image (en kilooctets)
                // taille max 1Mo
                $tailleMax = 1000000;
                if($size > $tailleMax)
                {
                    $errImg = 7;
                }

                if($errImg==0)
                {
                     // corriger les risques de caractères spéciaux dans le nom de fichier
                    $nomImageLisible = strtr($nomImage, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    $nomImageSafe = preg_replace('/([^.a-z0-9]+)/i', '-', $nomImageLisible);
                    $uniqnomSsafe = uniqid().'-'.$nomImageSafe;

                    if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier.$uniqnomSsafe))
                    {
                        // insertion dans la base de données
                        require "../config/connexion.php";
                        $insert = $bdd->prepare("INSERT INTO skills(nom,image) VALUES(?,?)");
                        $insert->execute([$nom,$uniqnomSsafe]);
                        // redirection vers la page categories.php avec indication du success
                        header("LOCATION:skills.php?add=success");
                        exit();
                    }
                    else{
                       header("LOCATION:addSkills.php?error=8");
                    exit(); 
                    }
                
                }else{
                    header("LOCATION:addSkills.php?error=".$errImg);
                    exit();
                }


                 
            }else{
                header("LOCATION:addSkills.php?error=2");
                exit();
            }

        }else{
            // il y a une erreur dans le formulaire
            // redirection vers la page formulaire avec indication de l'erreur
            header("LOCATION:addSkills.php?error=".$err);
            exit();
        }


    }else{
        // formulaire pas envoyé donc redirection
        header("LOCATION:addSkills.php");
        exit();
    }
?>