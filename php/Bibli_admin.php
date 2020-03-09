<?php

$PREFIXE = "01_";

require_once "Message.php";
require_once "Commentaire.php";
require_once "Chiot.php";
/**
 * BIBLIOTHEQUE POUR LE MODE ADMINISTRATEUR
 */

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
    '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>',
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
 * @param $array_chiots array tableau avec tous les chiots
 */
function print_message(Message $message,$numero_message,$array_chiots){
    echo '<div class="message col-md-12 rounded">',
            '<h3 class="d-inline">',$message->titre,'<em> par ',$message->author->nomChiot,'</em></h3><a href="index_admin.php?delPost='.$message->idMessage.'" class="d-inline float-right btn-danger rounded">Supprimer</a>',
            '<div class="msgBody">';


            if(count($message->url_image)>1){
                echo '<div class="container w-25 float-left">',
                        '<div id="carouselImage'.$message->idMessage.'" class="carousel slide" data-ride="carousel">',
                            '<ol class="carousel-indicators">';

                $cpt = 0;

                foreach ($message->url_image as $image){
                    echo '<li data-target="#carouselImage'.$message->idMessage.'" data-slide-to="'.$cpt.'"';
                    if($cpt==0){
                        echo ' class="active"';
                    }
                    echo '></li>';
                    $cpt++;
                }

                echo '</ol>';

                echo '<div class="carousel-inner">';

                $cpt=0;

                foreach ($message->url_image as $image){
                    echo '<div class="carousel-item';

                    if($cpt==0){
                        echo ' active';
                    }
                    echo '">',
                            '<img class="d-block w-100 " src="../'.$image.'">',
                        '</div>';

                    $cpt++;

                }

                echo '<a class="carousel-control-prev" href="#carouselImage'.$message->idMessage.'" role="button" data-slide="prev">',
                        '<span class="carousel-control-prev-icon" aria-hidden="true"></span>',
                        '<span class="sr-only">Precedent</span>',
                    '</a>';

                echo '<a class="carousel-control-next" href="#carouselImage'.$message->idMessage.'" role="button" data-slide="next">',
                '<span class="carousel-control-next-icon" aria-hidden="true"></span>',
                '<span class="sr-only">Suivant</span>',
                '</a>';


                echo        '</div>',
                        '</div>',
                     '</div>';



            }else {
              echo '<div class="img">',
                    '<img  src="',"../".$message->url_image[0],'">',
                '</div>';
            }

            echo    '<div class="texte">',
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
                $commentaire->author->nomChiot,' : ',$commentaire->contenu,'<br><em class="pr-3">',print_date_user($commentaire->date),'</em>', '<a href="index_admin.php?delComment='.$commentaire->idCommentaire.'" class="btn-danger rounded">Supprimer</a>',
            '<hr>',
            '</div>';
    }

    echo            '</div>',
            '</div>',
        '</div>',
    '</div>';
}

/**
 * Renvoie vers la sortie standard le code html de la nav bar pour les grands ecrans
 * @param array $array_chiots le tableau avec tous les chiens
 */
function print_nav_big($array_chiots){

    echo '<div class="navBig">',
    '<ul>';

    echo '<li><a class="N" href="index.php">Tous les chiots</a></li>';

    foreach ($array_chiots as $chiot){
        echo '<li><a href="index.php?idChiot='. $chiot->idChiot.'" class="'.$chiot->sexeChiot.'">'.$chiot->nomChiot.'</a></li>';
    }
/*
    for($i=1;$i<=$nbChiots;$i++){
        echo '<li><a href="index.php?idChiot='. $i .'">Chiot '.$i.'</a></li>';
    }*/

    echo '</ul>',
    '</div>';
}
/**
 * Renvoie vers la sortie standard le code html de la nav bar pour les petits ecrans
 * @param array $array_chiots le tableau avec tous les chiens
 */
function print_nav_small($array_chiots){
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
    }else {
        echo '>';
    }

    echo 'Tous les chiots</option>';


    foreach ($array_chiots as $chiot){
        echo '<option value="index.php?idChiot='.$chiot->idChiot.'"';

        if($idChiotSelected==$chiot->idChiot){
            echo 'selected>';
        }else {
            echo '>';
        }


        echo $chiot->nomChiot.'</option>';
    }


    echo '</ul>',
    '</select>';
}

/**
 * Fonction qui se connecte avec la base de données
 * @return PDO L'objet PDO representant la connexion avec la BD
 */
function connectToBdd(){
    $pdo = new PDO("mysql:localhost=localhost;dbname=rs_chiens_tutored", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

/**
 * Fonction qui supprime un post de la base de données
 * @param PDO $pdo
 * @param int $idPost L'id du post que l'on veut supprimer
 */
function deletePost(PDO $pdo,$idPost){
    global $PREFIXE;
    $idImage =  $pdo->query("SELECT idImageAssoc FROM ".$PREFIXE."posts WHERE idPost=$idPost")->fetchColumn();
    if(strlen($idImage)>0){
        $sql = "DELETE FROM ".$PREFIXE."imagepost WHERE idImage=$idImage";
        $pdo->query($sql);
    }
    $sql = "DELETE FROM ".$PREFIXE."posts WHERE idPost=$idPost";
    $pdo->query($sql);
    $sql = "DELETE FROM ".$PREFIXE."comments WHERE idPost=$idPost";
    $pdo->query($sql);
}
/**
 * Fonction qui supprime un commentaire de la base de données
 * @param PDO $pdo
 * @param int $idComment L'id du commentaire que l'on veut supprimer
 */
function deleteComment(PDO $pdo, $idComment){
    global $PREFIXE;
    $sql = "DELETE FROM ".$PREFIXE."comments WHERE idComment=$idComment";
    $pdo->query($sql);
}

/**
 * Fonction qui retourne un tableau avec tous les posts
 * @param PDO $pdo
 * @param int $chiotSelected Le chiot selectionné
 * @param array $array_chiots le tableau avec tous les chiots repertoriés
 * @return array Le tableau de tous les posts
 */
function arrayPosts(PDO $pdo, $chiotSelected, $array_chiots){
    global $PREFIXE;
    $sql = "SELECT * FROM ".$PREFIXE."posts";
    if($chiotSelected!=-1){
        $sql = $sql." WHERE idChiot = ".$chiotSelected;
    }

    $pdostat = $pdo->query($sql);
    $pdostat->setFetchMode(PDO::FETCH_ASSOC);

    $array = array();

    foreach ($pdostat as $item){
        $pdo2stat = $pdo->query("SELECT * FROM ".$PREFIXE."comments WHERE idPost=" . $item["idPost"]);
        $pdo2stat->setFetchMode(PDO::FETCH_ASSOC);

        $array_comm = array();
        $chiot_tmp1 = null;
        foreach ($pdo2stat as $comm_item){
            foreach ($array_chiots as $chiot){
                if($comm_item["idChiotAuteur"]==$chiot->idChiot){
                    $chiot_tmp1 = $chiot;
                }
            }
            array_push($array_comm,new Commentaire($chiot_tmp1,$comm_item["txtComment"],$comm_item["dateComment"],$comm_item["idComment"]));
        }

        usort($array_comm,function ($a,$b){
            $ad = new DateTime($a->date);
            $bd = new DateTime($b->date);

            if ($ad == $bd) {
                return 0;
            }

            return $ad < $bd ? -1 : 1;
        });

        $pdo3stat = $pdo->query("SELECT * FROM ".$PREFIXE."imagepost WHERE idImage=" . $item["idImageAssoc"]);
        $pdo3stat->setFetchMode(PDO::FETCH_ASSOC);

        $chiot_tmp = null;
        foreach ($array_chiots as $chiot){
            if($item["idChiot"]==$chiot->idChiot){
                $chiot_tmp = $chiot;
            }
        }

        foreach ($pdo3stat as $image_item){
            $array_image = array();
            if(strlen($image_item["urlImage4"])!=0){
                array_push($array_image,$image_item["urlImage4"]);
            }
            if(strlen($image_item["urlImage3"])!=0){
                array_push($array_image,$image_item["urlImage3"]);
            }
            if(strlen($image_item["urlImage2"])!=0){
                array_push($array_image,$image_item["urlImage2"]);
            }

                array_push($array_image,$image_item["urlImage1"]);

            array_push($array,new Message($chiot_tmp,$array_image,$array_comm,$item["txtPost"],$item["datePost"],$item["idPost"],$item["titre"]));

        }

    }
    usort($array,function ($a,$b){
        $ad = new DateTime($a->date);
        $bd = new DateTime($b->date);

        if ($ad == $bd) {
            return 0;
        }

        return $ad < $bd ? 1 : -1;
    });
    return $array;
}

function countChiots(PDO $pdo){
    global $PREFIXE;
    return $pdo->query("SELECT COUNT(*) FROM ".$PREFIXE."chiots")->fetchColumn();
}

/**
 * Fonction qui renvoie un tableau d'objets Chiots
 * @param PDO $pdo
 * @return array Le tableau avec toutes les chaines de caracteres renvoyées
 */
function getAllChiots(PDO $pdo){
    global $PREFIXE;
    $sql = "SELECT * FROM ".$PREFIXE."chiots";
    $pdostat = $pdo->query($sql);
    $pdostat->setFetchMode(PDO::FETCH_ASSOC);

    $array = array();

    foreach ($pdostat as $item){
        array_push($array,new Chiot($item["idChiot"],$item["nomChiot"],$item["sexe"]));
    }

    return $array;
}

/**
 * Renvoie une chaine representant une date que l'on peut afficher
 * @param string $date la date que l'on veut afficher
 * @return string
 */
function print_date_user($date) {
    $jour = explode(" ",$date)[0];
    $heure = explode(" ",$date)[1];
    $string = "";

    $split = explode("-",$jour);

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

    $string = $string ." ".  $split[0]. " à ".$heure;
    return $string;
}

