<?php

require_once "Bibli.php";

//Affichage de l'entete du html
print_head('Chiots','style_final.css');

//Connexion a la base de données
$pdo = connectToBdd();

//Comptage du nombre de chiens
$nbChiots = countChiots($pdo);

//on rempli un tableau de tous les chiots :
$arrayChiots = getAllChiots($pdo);

//On regarde si il y a un chien de selectionne

if(isset($_GET['idChiot'])){
    $chiotSelected = $_GET['idChiot'];
}else {
    $chiotSelected = -1;
}

//Ajout du commentaire :

if(isset($_GET['comment'])){
    $newCommentaire = new Commentaire($_POST['auteurComment'],$_POST['txtComment'],date("Y-m-d H:i:s"),0);
    add_Comment($pdo,$_GET['comment'],$newCommentaire);
}

//Gestion du message d'erreur lors de l'ajout de post
$messageError = "";
if(isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $messageError = 'Le fichier n\'est pas une image';
            break;
        case 2:
            $messageError = 'Désolé, l\'image est trop grande';
            break;
        case 3:
            $messageError = 'Désolé, l\'image n\'est pas du bon type';
            break;
        case 4:
            $messageError = 'Désolé, il y a eu une erreur lors de la publication de l\'image!';
            break;
        case 5:
            $messageError = 'Vous n\'avez pas renseigné de titre !';
            break;
    }
}
echo '<body>';

//Affichage de la partie pour saisir un message

print_header($arrayChiots,$messageError);

//Affichage de la navbar (si grand ecran)
print_nav_big($arrayChiots);



echo '<div class="mainBody ">';
//Affichage de la selection de chien (si petit ecran)
print_nav_small($arrayChiots);


//Récuperation de l'ensemble des messages
$tab_message = arrayPosts($pdo,$chiotSelected,$arrayChiots);

//Affichage des messages postés
$compteur = 0;
foreach ($tab_message as $message){
    print_message($message,$compteur,$arrayChiots);
    $compteur++;
}





echo '</div></body></html>';
?>


