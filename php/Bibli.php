<?php
/**
 * Created by PhpStorm.
 * User: zieda
 * Date: 04/02/2020
 * Time: 22:03
 */

require_once "Message.php";
require_once "Commentaire.php";
/**
 * Renvoie vers la sortie standard le debut du code html
 *
 * @param string $titre titre de la page
 * @param string $css chemin vers le css qu'on ajoute a la page
 */
function print_head($titre='',$css=''){
    $titre = htmlentities($titre,ENT_COMPAT,'ISO-8859-1');

    echo    '<!DOCTYPE html>',
    '<html lang=fr>',
    '<head>',
    '<meta charset="UTF-8">',
    '<title>',$titre,'</title>',
    '<meta name="viewport" content="width=device-width, initial-scale=1">',
        //JS
    '<script src="../js/bootstrap.js"></script>',
        //CSS
    '<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />',
        //NOTRE CSS
    "<link href='../css/$css' rel='stylesheet' type='text/css'>",
    '</head>';
}

/**
 * Renvoie vers la sortie standard le code html d'un message
 * @param $message Message
 * @param $numero_message int numero du message (pour pouvoir tous les differencier)
 */
function print_message(Message $message,$numero_message){
    echo '<div class="message col-md-12">',
            '<h3>',$message->author,'</h3>',
            '<div class="msgBody">',
                '<div class="img">',
                    '<img  src="',$message->url_image,'">',
                '</div>',
                '<div class="texte">',
                    $message->contenu,
                '</div>',
            '</div>',
            '<div class="msgFooter">',
                '<div>',$message->date,'</div>',
                    '<div>',
                        '<label for="toggleComments-',$numero_message,'">Afficher les commentaires</label>',
                        '<input type="checkbox" class="toggleComments" id="toggleComments-',$numero_message,'">',
                        '<div class="commentaires">',
                            '<h4>Commentaires : </h4>';
    //Boucle pour mettre tous les commentaires sous le message
    foreach ($message->tableau_commentaires as $commentaire){
        echo '<div class="commentaire">',
                $commentaire->author,':',$commentaire->contenu,
            '</div>';
    }
    echo                '</div>',
                    '</div>',
                '</div>',
            '</div>';
}


function print_nav_big(){
    echo '<div class="navBig">',
    '<ul>',
    '<li><a href="index.php?nomChiot=\'chiot1\'">chiot1</a></li>',
    '<li><a href="index.php?nomChiot=\'chiot2\'">chiot2</a></li>',
    '<li><a href="index.php?nomChiot=\'chiot3\'">chiot3</a></li>',
    '</ul>',
    '</div>';
}

function print_nav_small(){
    echo '<select class="navSmall" onchange="window.open(this.value,\'_self\');">',
    '<ul>',
    '<option value="index.php">Tous les chiots</option>',
    '<option value="index.php?nomChiot=\'chiot1\'">Page 1</option>',
    '<option value="index.php?nomChiot=\'chiot2\'">Page 2</option>',
    '<option value="index.php?nomChiot=\'chiot3\'">Page 3</option>',
    '</ul>',
    '</select>';
}


function connectToBdd(){
    $pdo = new PDO("mysql:localhost=localhost;dbname=rs_chiens_tutored", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

/**
 * Fonction qui retourne un tableau avec tous les posts
 * @param PDO $pdo
 * @return array Le tableau de tous les posts
 */
function arrayPosts(PDO $pdo){
    $pdostat = $pdo->query("SELECT * FROM posts");
    $pdostat->setFetchMode(PDO::FETCH_ASSOC);

    $array = array();

    foreach ($pdostat as $item){
        $pdo2stat = $pdo->query("SELECT * FROM comments WHERE idPost=" . $item["idPost"]);
        $pdo2stat->setFetchMode(PDO::FETCH_ASSOC);

        $array_comm = array();

        foreach ($pdo2stat as $comm_item){
            array_push($array_comm,new Commentaire("Chiot ".$comm_item["idChiotAuteur"],$comm_item["txtComment"],$comm_item["dateComment"]));
        }

        $pdo3stat = $pdo->query("SELECT urlImage1 FROM imagepost WHERE idImage=" . $item["idImageAssoc"]);
        $ligne = $pdo3stat->fetch();


        array_push($array,new Message("Chiot ".$item["idChiot"],$ligne["urlImage1"],$array_comm,$item["txtPost"],$item["datePost"]));
    }

    return $array;
}
