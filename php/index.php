<?php
/**
 * Created by PhpStorm.
 * User: zieda
 * Date: 04/02/2020
 * Time: 22:06
 */

require_once "bibli.php";

//Affichage de l'entete du html
print_head('Chiots','style_final.css');

//Connexion a la base de données
$pdo = connectToBdd();

//Comptage du nombre de chiens
$nbChiots = countChiots($pdo);

//On regarde si il y a un chien de selectionne

if(isset($_GET['idChiot'])){
    $chiotSelected = $_GET['idChiot'];
}else {
    $chiotSelected = -1;
}

//Ajout du commentaire :

if(isset($_GET['comment'])){
    $newCommentaire = new Commentaire($_POST['auteurComment'],$_POST['txtComment'],date("Y-m-d"));
    add_Comment($pdo,$_GET['comment'],$newCommentaire);
}

if(isset($_GET['error'])){
    switch ($_GET['error']){
        case 1:
            $messageError='Le fichier n\'est pas une image';
            break;
        case 2:
            $messageError='Désolé, l\'image est trop grande';
            break;
        case 3:
            $messageError='Désolé, l\'image n\'est pas du bon type';
            break;
        case 4:
            $messageError = 'Désolé, il y a eu une erreur lors de la publication de l\'image!';
            break;
    }
}else{
    $messageError="";
}
echo '<body>';

print_header($nbChiots,$messageError);

print_nav_big($nbChiots);



echo '<div class="mainBody ">';

print_nav_small($nbChiots);
//TODO REMPLIR LES POST AVEC CEUX DE LA BASE DE DONNEE !!!!!

/*
$tab_comm = array(new Commentaire('Chiot 1','blablabla','01/01/2020'),
    new Commentaire('Chiot 1','blablabla','01/01/2020'),
    new Commentaire('Chiot 2','blablabla','01/01/2020'),
    new Commentaire('Chiot 3','blablabla','01/01/2020'));
$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mi interdum, faucibus ipsum vitae, efficitur purus. Curabitur convallis a lacus non luctus. Cras dignissim convallis scelerisque. Ut iaculis consectetur eleifend. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc in eleifend nisl. Proin vitae sodales nunc.';
$url = '../img/patrick.jpg';
$tab_message = array(new Message('Chiot 1',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 2',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 3',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 4',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 5',$url,$tab_comm,$content,'01/01/2020'));
$compteur = 0;
*/



$tab_message = arrayPosts($pdo,$chiotSelected);
$compteur = 0;

foreach ($tab_message as $message){
    print_message($message,$compteur,$nbChiots);
    $compteur++;
}
echo '</div></body></html>';
?>

