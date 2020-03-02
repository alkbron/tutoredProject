<?php
require_once "php/Bibli.php";
/*
 * ERREURS POSSIBLES :
 *
 * 1 -> Le fichier n'est pas une image
 * 2-> Désolé, l'image est trop grande
 * 3 -> Désolé, l'image n'est pas du bon type
 * 4 -> Désolé, il y a eu une erreur lors de la publication de l'image!
 *
 */
if($_FILES["fileToUpload"]["tmp_name"]!=""){
    //Il y a bien un fichier à traiter
    $target_dir = "uploads/";
    $nbFich = 0;
    $nom_fichier = "chiot".$_POST['auteur']."_".$nbFich;

    $_FILES["fileToUpload"]["name"] = $nom_fichier.".jpg";

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    echo "Numero de l'autheur : ".$_POST['auteur']."    ";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// On regarde si le fichier est une "vraie" image ou pas
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $error = 1;
            $uploadOk = 0;
        }
    }
// On renomme le fichier
    while (file_exists($target_file)) {
        if(substr($nom_fichier,-1)==9){
            $nom_fichier = substr($nom_fichier,0,-1);
            $nom_fichier = $nom_fichier."10";
        }else {
            $last = substr($nom_fichier,-1);
            $last++;
            $nom_fichier = substr($nom_fichier,0,-1);
            $nom_fichier = $nom_fichier.$last;
        }
        $_FILES["fileToUpload"]["name"] = $nom_fichier.".jpg";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    }
// On regarde la taille de l'image
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error = 2;
        $uploadOk = 0;
    }
// On autorise que certains type d'images
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $error = 3;
        $uploadOk = 0;
    }


// Si $uploadOk est egal a 0, on n'upload pas le fichier
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// Si tout est ok, on upload le fichier
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            $pdo = connectToBdd();
            $array = array();
            $message = new Message($_POST["auteur"],$target_file,$array,$_POST['content_post'],date("Y-m-d"),0);
            addPost($pdo,$message);



        } else {
            $error = 4;
        }
    }

}
header("Location: php/index.php?error=$error");
die;
?>
