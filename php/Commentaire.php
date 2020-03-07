<?php
/**
 * Created by PhpStorm.
 * User: zieda
 * Date: 04/02/2020
 * Time: 22:28
 */

class Commentaire
{
    public $author;
    public $contenu;
    public $date;
    public $idCommentaire;

    /**
     * Commentaire constructor.
     * @param $author
     * @param $contenu
     * @param $date
     * @param $idCommentaire
     */
    public function __construct($author, $contenu, $date,$idCommentaire)
    {
        $this->author = $author;
        $this->contenu = $contenu;
        $this->date = $date;
        $this->idCommentaire = $idCommentaire;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}