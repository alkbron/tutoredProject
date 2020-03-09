<?php
require_once "Bibli_admin.php";

//Affichage de l'entete du html
print_head('ADMINChiots','style_final.css');

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

if(isset($_GET["delPost"])){
    deletePost($pdo,$_GET["delPost"]);
}

if(isset($_GET["delComment"])){
    deleteComment($pdo,$_GET["delComment"]);
}

echo '<body>';
echo '<h1 class="text-center bg-danger">MODE ADMINISTRATION </h1>';
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


