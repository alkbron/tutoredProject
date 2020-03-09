<?php

$PREFIXE = "01_";
require_once "php/Bibli.php";
/*
 * ERREURS POSSIBLES :
 *
 * 1 -> Le fichier n'est pas une image
 * 2-> Désolé, l'image est trop grande
 * 3 -> Désolé, l'image n'est pas du bon type
 * 4 -> Désolé, il y a eu une erreur lors de la publication de l'image!
 * 5 -> Vous n'avez pas renseigné de titre !
 */
$array_url = array();
if(strlen($_POST["txt_titre"])==0){
    $error = 5;
}else {

    for($i=1;$i<5;$i++){
        $nom_files = "fileToUpload".$i;


        $error = 0;
        if ($_FILES[$nom_files]["tmp_name"] != "") {
            //Il y a bien un fichier à traiter
            $target_dir = "uploads/";
            $nbFich = 0;
            $nom_fichier = $PREFIXE."chiot" . $_POST['auteur'] . "_" . $nbFich;

            $_FILES[$nom_files]["name"] = $nom_fichier . ".jpg";

            $target_file = $target_dir . basename($_FILES[$nom_files]["name"]);

            echo "Numero de l'autheur : " . $_POST['auteur'] . "    ";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// On regarde si le fichier est une "vraie" image ou pas
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES[$nom_files]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {

                    $uploadOk = 0;
                    if($i==1){
                        $error = 1;
                        continue;
                    }else {
                        continue;
                    }

                }
            }
// On renomme le fichier
            while (file_exists($target_file)) {
                if (substr($nom_fichier, -1) == 9) {
                    $nom_fichier = substr($nom_fichier, 0, -1);
                    $nom_fichier = $nom_fichier . "10";
                } else {
                    $last = substr($nom_fichier, -1);
                    $last++;
                    $nom_fichier = substr($nom_fichier, 0, -1);
                    $nom_fichier = $nom_fichier . $last;
                }
                $_FILES[$nom_files]["name"] = $nom_fichier . ".jpg";
                $target_file = $target_dir . basename($_FILES[$nom_files]["name"]);
            }
// On regarde la taille de l'image
            if ($_FILES[$nom_files]["size"] > 500000) {

                $uploadOk = 0;
                if($i==1){
                    $error = 2;
                    continue;
                }else {
                    continue;
                }
            }
// On autorise que certains type d'images
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $uploadOk = 0;
                if($i==1){
                    $error = 3;
                    continue;
                }else {
                    continue;
                }

            }


// Si $uploadOk est egal a 0, on n'upload pas le fichier
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
// Si tout est ok, on upload le fichier
            } else {
                if (move_uploaded_file($_FILES[$nom_files]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES[$nom_files]["name"]) . " has been uploaded.";

                    $array = array();
                    //ICI On va ajouter l'url de l'image au tableau d'image, pour ensuite enregistrer tout cela dans la base de donnees
                    array_push($array_url,$target_file);


                } else {
                    if($i==1){
                        $error = 4;
                    }
                }
            }

        }
    echo "\n\n\n";
    }


}
if(count($array_url)>0){
    $pdo = connectToBdd();
    $message = new Message($_POST["auteur"], $array_url,$array, $_POST['content_post'], date("Y-m-d"), 0, $_POST["txt_titre"]);
    addPost($pdo, $message);

}

if($error!=0){

    header("Location: php/index.php?error=$error");
    die;
}else {
    header("Location: php/index.php");
    die;
}
?>
