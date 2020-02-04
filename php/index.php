<?php
/**
 * Created by PhpStorm.
 * User: zieda
 * Date: 04/02/2020
 * Time: 22:06
 */

require_once "bibli.php";

print_head('Chiots','style.css');
echo '<body><div class="mainBody">';

print_nav();

$tab_comm = array(new Commentaire('Chiot 1','blablabla','01/01/2020'),
    new Commentaire('Chiot 1','blablabla','01/01/2020'),
    new Commentaire('Chiot 2','blablabla','01/01/2020'),
    new Commentaire('Chiot 3','blablabla','01/01/2020'));
$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mi interdum, faucibus ipsum vitae, efficitur purus. Curabitur convallis a lacus non luctus. Cras dignissim convallis scelerisque. Ut iaculis consectetur eleifend. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc in eleifend nisl. Proin vitae sodales nunc.';
$url = 'https://hrdevelopmentinfo.com/wp-content/uploads/2016/01/Article-5_Picture-1_Brain-illustration-1.jpg';
$tab_message = array(new Message('Chiot 1',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 2',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 3',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 4',$url,$tab_comm,$content,'01/01/2020'),
    new Message('Chiot 5',$url,$tab_comm,$content,'01/01/2020'));
$compteur = 0;
foreach ($tab_message as $message){
    print_message($message,$compteur);
    $compteur++;
}
echo '</div></body></html>';
?>

