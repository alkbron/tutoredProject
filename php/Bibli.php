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
    '<script src="../js/jquery-3.4.1.js"></script>',
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
 * @param $nbChiots int nombre de chiots dans la page
 */
function print_message(Message $message,$numero_message,$nbChiots){
    echo '<div class="message col-md-12">',
            '<h3>',$message->author,'</h3>',
            '<div class="msgBody">',
                '<div class="img">',
                    '<img  src="',"../".$message->url_image,'">',
                '</div>',
                '<div class="texte">',
                    $message->contenu,
                '</div>',
            '</div>',
            '<div class="msgFooter">',
                '<div>',print_date_user($message->date),'</div>',
                    '<div>',
                        '<label for="toggleComments-',$numero_message,'">Afficher les commentaires</label>',
                        '<input type="checkbox" class="toggleComments" id="toggleComments-',$numero_message,'">',
                        '<div class="commentaires">',
                            '<h4>Commentaires : </h4>';
    //Boucle pour mettre tous les commentaires sous le message
    foreach ($message->tableau_commentaires as $commentaire){
        echo '<div class="commentaire">',
                $commentaire->author,' : ',$commentaire->contenu,
            '</div>';
    }
    echo '<div>',
            "<form action='index.php?comment=$message->idMessage' method='POST'>",
                'Entrez votre commentaire : ',
                '<input type="text" name="txtComment">',
    '<select name="auteurComment">';

    for($i=1;$i<=$nbChiots;$i++){
        echo '<option value="'.$i.'">Chiot '.$i.'</option>';
    }

    echo   '</select>',
                '<input type="submit" value="Postez !">',

                        '</form>',
                    '</div>',
                '</div>',
            '</div>',
        '</div>',
    '</div>';
}


function print_nav_big($nbChiots){

    echo '<div class="navBig">',
    '<ul>';

    echo '<li><a href="index.php">Tous les chiots</a></li>';

    for($i=1;$i<=$nbChiots;$i++){
        echo '<li><a href="index.php?idChiot='. $i .'">Chiot '.$i.'</a></li>';
    }

    echo '</ul>',
    '</div>';
}

function print_nav_small($nbChiots){
    if(isset($_GET['idChiot'])){
        $idChiotSelected = $_GET['idChiot'];
    }else {
        $idChiotSelected = -1;
    }

    echo '<select class="navSmall" onchange="window.open(this.value,\'_self\');">',
    '<ul>';

    echo '<option value="index.php?idChiot=-1"';

    if($idChiotSelected==-1){
        echo 'selected>';
    }

    echo 'Tous les chiots</option>';

    for($i=1;$i<=$nbChiots;$i++){
        echo '<option value="index.php?idChiot='.$i.'"';

        if($idChiotSelected==$i){
            echo 'selected>';
        }

        echo 'Chiot '.$i.'</option>';
    }

    echo '</ul>',
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
 * @param int $chiotSelected Le chiot selectionné
 * @return array Le tableau de tous les posts
 */
function arrayPosts(PDO $pdo, $chiotSelected){

    $sql = "SELECT * FROM posts";
    if($chiotSelected!=-1){
        $sql = $sql." WHERE idChiot = ".$chiotSelected;
    }

    $pdostat = $pdo->query($sql);
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


        array_push($array,new Message("Chiot ".$item["idChiot"],$ligne["urlImage1"],$array_comm,$item["txtPost"],$item["datePost"],$item["idPost"]));
    }
    usort($array,"compareDate");
    return $array;
}

function countChiots(PDO $pdo){
    return $pdo->query("SELECT COUNT(*) FROM chiots")->fetchColumn();
}

/**
 * Compare 2 dates sous la forme SQL pour pouvoir par exemple trier un tableau
 * @param $post1
 * @param $post2
 *
 * @return int $res 1 si 2 apres 1, -1 sinon, 0 si egales
 */
function compareDate(Message $post1,Message $post2)
{
    $date1 = $post1->date;
    $date2 = $post2->date;

    $split1 = explode("-", $date1);
    $split2 = explode("-", $date2);

    if ($split1[0] < $split2[0]) {
        return 1;
    }

        if ($split1[0] > $split2[0]) {
            return -1;
        }
            //Les deux annees sont egales
            if ($split1[1] < $split2[1]) {
                return 1;
            }
                if ($split1[1] > $split2[1]) {
                    return -1;
                }
                    //Les deux mois sont egaux
                    if ($split1[2] < $split2[2]) {
                        return 1;
                    }
                        if ($split1[2] > $split2[2]) {
                            return -1;
                        }
    return 0;
}

function print_header($nbChiots,$messageError){
    echo '<header class="text-white">',
            '<form action="../upload.php" method="post" enctype="multipart/form-data">',
                '<table>',
                    '<tr>',
                        '<td><textarea id="content_post" name="content_post"></textarea></td>',
                    '</tr>',
                    '<tr>',
                        '<td><input type="file" id="fileToUpload" name="fileToUpload"></td>';
    echo '<td>',
        '<select name="auteur">';

    for($i=1;$i<=$nbChiots;$i++){
        echo '<option value="'.$i.'">Chiot '.$i.'</option>';
    }

     echo   '</select>',
        '</td>';
    echo        '<td><input type="submit" value="Postez" name="submit"></td>',
                    '</tr>',
            "<td class='error'>$messageError</td>",
                '</table>',
            '</form>',
        '</header>';
}

function addPost(PDO $pdo, Message $message){
    $idPost = lastIDPost($pdo) + 1 ;

    $sql = "INSERT INTO posts (idPost,txtPost,idImageAssoc,idChiot,datePost) VALUES ($idPost,'$message->contenu',$idPost,'$message->author','$message->date')";
    echo $sql;
    $pdo->query($sql);

    $sql = "INSERT INTO imagepost (idImage,urlImage1,urlImage2,urlImage3,urlImage4) VALUES ($idPost,'$message->url_image','','','')";
    echo $sql;
    $pdo->query($sql);
}

function lastIDPost(PDO $pdo){
    return $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
}

function lastIDComment(PDO $pdo){
    return $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
}

function add_Comment($pdo,$idPost,Commentaire $commentaire){
    $idComment = lastIDComment($pdo) + 1;

    $sql = "INSERT INTO comments (idComment,txtComment,idChiotAuteur,idPost,dateComment) VALUES ($idComment,'$commentaire->contenu',$commentaire->author,$idPost,'$commentaire->date')";
    echo $sql;
    $pdo->query($sql);
}

function print_date_user($date) {
    $string = "";

    $split = explode("-",$date);

    $string = "Le $split[2] ";

    switch ($split[1]){
        case "01":
            $string = $string . "Janvier";
            break;
        case "02":
            $string = $string . "Février";
            break;
        case "03":
            $string = $string . "Mars";
            break;
        case "04":
            $string = $string . "Avril";
            break;
        case "05":
            $string = $string . "Mai";
            break;
        case "06":
            $string = $string . "Juin";
            break;
        case "07":
            $string = $string . "Juillet";
            break;
        case "08":
            $string = $string . "Aout";
            break;
        case "09":
            $string = $string . "Septembre";
            break;
        case "10":
            $string = $string . "Octobre";
            break;
        case "11":
            $string = $string . "Novembre";
            break;
        case "12":
            $string = $string . "Décembre";
            break;
    }

    $string = $string ." ".  $split[0];
    return $string;
}

