<?php
session_start();
// sécuritè pour la connexion
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
    exit();
}

// besoin de l'id pour la bdd et fonctionner
if(!isset($_GET['id']) && !is_numeric($_GET['id']))
{
    header("LOCATION:products.php");
    exit();
}else // sinon on continue
{
    // proctection de l'id pour son utilisation dans la bdd
    $id = htmlspecialchars($_GET['id']);
}


// vérifier si le produit existe avec l'aide de l'id
// besoin de la bdd
require "../config/connexion.php";

$req = $bdd->prepare("SELECT * FROM products WHERE id=?");
$req->execute([$id]);

$don = $req->fetch(PDO::FETCH_ASSOC);
if(!$don)
{
    header("LOCATION:products.php");
    exit();
}


// vérification de l'envoie du formulaire'
if(isset($_POST['nom']))
{

    $err = 0;


    if(empty($_POST['nom']))
    {
        $err= 1;
    }else{
        $nom = htmlspecialchars($_POST['nom']);
    }

    if(empty($_POST['date']))
    {
        $err= 2;
    }else{
        $date = htmlspecialchars($_POST['date']);
    }

    if(empty($_POST['description']))
    {
        $err= 3;
    }else{
        $description = htmlspecialchars($_POST['description']);
    }

    if(empty($_POST['categorie']))
    {
        $err= 4;
    }else{
        $categorie = htmlspecialchars($_POST['categorie']);
    }

    if($err == 0)
    {
        // si tu as envoyé une image
        if($_FILES['cover']['error'] == 0)
        {
            // update avec image
            // récup des infos de l'image (nom, extension, type, taille)
            $nomImage = basename($_FILES['cover']['name']);
            $extension = strrchr($_FILES['cover']['name'],'.');
            $mimeType = $_FILES['cover']['type'];
            $size = filesize($_FILES['cover']['tmp_name']);


            $dossier = "../images/";
            $errImg = 0;

            // vérification des données de l'image

            $extensionsAcceptees = ['.jpg','.jpeg','.png','.gif'];
            if(!in_array($extension,$extensionsAcceptees))
            {
                $errImg = 5;
            }

            // vérification du type MIME (type de fichier)
            $mimeTypesAcceptes = ['image/jpeg','image/jpg','image/png','image/gif'];
            if(!in_array($mimeType,$mimeTypesAcceptes))
            {
                $errImg = 6;
            }

            // vérification de la taille de l'image (en kilooctets)
            $tailleMax = 1000000;
            if($size > $tailleMax)
            {
                $errImg = 7;
            }

            // vérification des erreurs personnalisées de l'upload de l'image
            if($errImg == 0)
            {

                $nomImageLisible = strtr($nomImage, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $nomImageSafe = preg_replace('/([^.a-z0-9]+)/i', '-', $nomImageLisible);
                $uniqnomSsafe = uniqid().'-'.$nomImageSafe;

                if(move_uploaded_file($_FILES['cover']['tmp_name'],$dossier.$uniqnomSsafe))
                {
                    // supprimer l'ancienne image
                    unlink($dossier.$don['cover']);
                    // update de la base de données
                    /**
                     * @var $bdd PDO
                     */
                    $update = $bdd->prepare("UPDATE products SET name=:nom, date=:date, category=:category, description=:descri, cover=:img WHERE id = :myid");
                    $update->execute([
                        ":nom" => $nom,
                        ":date"=>$date,
                        ":category"=>$categorie,
                        ":descri"=>$description,
                        ":img"=>$uniqnomSsafe,
                        ":myid"=>$id
                    ]);
                    header("LOCATION:products.php?update=".$id);
                    exit();

                }else{
                    // il y a eu un problème au niveau du déplacement de l'image donc erreur avec indication
                    header("LOCATION:updateProduct.php?id=".$id."&errorImg=8");
                    exit();
                }

            }else{
                // il y a une erreur personnalisée dans l'upload de l'image
                header("LOCATION:updateProduct.php?id=".$id."&errorImg=".$errImg);
                exit();
            }

        }elseif($_FILES['cover']['error'] == 4) // tu n'as pas envoyé d'image
        {
          // update sans image
            $update = $bdd->prepare("UPDATE products SET name=:nom, date=:date, category=:category, description=:descri WHERE id = :myid");
            $update->execute([
                ":nom" => $nom,
                ":date"=>$date,
                ":category"=>$categorie,
                ":descri"=>$description,
                ":myid"=>$id
            ]);
            header("LOCATION:products.php?update=".$id);
            exit();
        }else // tu as envoyé une image mais il y a eu une erreur de $_FILES['cover']['error']
        {
            // $_FILES['cover']['error'] est différent de 0 ou de 4 donc il y a eu une erreur (1,2 ou 3)
            // redirection vers la page d'ajout avec l'indication de l'erreur (en mode GET ?errorImg=1)
            header("LOCATION:updateProduct.php?id=".$id."&errorImg=".$_FILES['cover']['error']);
            exit();
        }

    }else{
        // si il y a une erreur, on redirige vers la page d'ajout avec l'indication de l'erreur (en mode GET ?id=5&error=1)
        header("LOCATION:updateProduct.php?id=".$id."&error=".$err);
        exit();
    }

}else{
    // si pas de post on redirige vers la page d'accueil donc pas passé par le formulaire
    header("LOCATION:index.php");
    exit();
}
?>