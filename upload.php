<?php
require_once "php/Bibli.php";

$target_dir = "uploads/";
$nbFich = 0;
$nom_fichier = "chiot".$_POST['auteur']."_".$nbFich;

$_FILES["fileToUpload"]["name"] = $nom_fichier.".jpg";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

echo "Numero de l'autheur : ".$_POST['auteur']."    ";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
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
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        //TODO faire l'ajout pour la base de donnees ici

        $pdo = connectToBdd();
        $array = array();
        $message = new Message($_POST["auteur"],$target_file,$array,$_POST['content_post'],date("Y-m-d"));
        addPost($pdo,$message);

        header('Location: php/index.php');
        die;

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
