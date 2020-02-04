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
    echo '<div class="message">',
            '<h3>',$message->author,'</h3>',
            '<div class="msgBody">',
                '<img class="img" src="',$message->url_image,'">',
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

function print_nav(){
    echo '<div class="nav">',
            '<ul>',
                '<li><a href="index.php?nomChiot=\'chiot1\'">chiot1</a></li>',
                '<li><a href="index.php?nomChiot=\'chiot2\'">chiot2</a></li>',
                '<li><a href="index.php?nomChiot=\'chiot3\'">chiot3</a></li>',
            '</ul>',
        '</div>';
}