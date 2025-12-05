<?php
session_start();
if(!isset($_SESSION['login']))
{
    header("LOCATION:index.php");
    exit();
}
	
$source = imagecreatefrompng("../images/".$_GET['image']); // La photo est la source




// getimagesize retourne un array contenant la largeur [0] et la hauteur [1]

$TailleImageChoisie = getimagesize("../images/".$_GET['image']);

// je définis la largeur de mon image.
$NouvelleLargeur = 300;

 

//  je calcule le pourcentage de réduction qui correspond au quotient de l'ancienne largeur par la nouvelle.

$Reduction = ( ($NouvelleLargeur * 100)/$TailleImageChoisie[0] );

 

//  je détermine la hauteur de la nouvelle image en appliquant le pourcentage de réduction à l'ancienne hauteur.

$NouvelleHauteur = ( ($TailleImageChoisie[1] * $Reduction)/100 );


$destination =  imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur"); // On crée la miniature vide


/* Pour garder la transparence du fichier png */
imagealphablending( $destination, false );
imagesavealpha( $destination, true );


// On crée la miniature

imagecopyresampled($destination, $source, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);


// On enregistre la miniature sous le nom "mini_"

$rep_nom="../images/mini_".$_GET['image'];

imagepng($destination,$rep_nom);

// redirection
if(isset($_GET['update']))
{
    header("LOCATION:products.php?update=".$_GET['update']);
}else{
    header("LOCATION:products.php?add=success");
}



?>