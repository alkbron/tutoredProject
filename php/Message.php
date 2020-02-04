<?php
/**
 * Created by PhpStorm.
 * User: zieda
 * Date: 04/02/2020
 * Time: 22:19
 */

class Message
{
    public $author;
    public $url_image;
    public $tableau_commentaires;
    public $contenu;
    public $date;

    /**
     * Message constructor.
     * @param $author
     * @param $url_image
     * @param $tableau_commentaires
     * @param $contenu
     * @param $date
     */
    public function __construct($author, $url_image, $tableau_commentaires, $contenu, $date)
    {
        $this->author = $author;
        $this->url_image = $url_image;
        $this->tableau_commentaires = $tableau_commentaires;
        $this->contenu = $contenu;
        $this->date = $date;
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
    public function getUrlImage()
    {
        return $this->url_image;
    }

    /**
     * @param mixed $url_image
     */
    public function setUrlImage($url_image)
    {
        $this->url_image = $url_image;
    }

    /**
     * @return mixed
     */
    public function getTableauCommentaires()
    {
        return $this->tableau_commentaires;
    }

    /**
     * @param mixed $tableau_commentaires
     */
    public function setTableauCommentaires($tableau_commentaires)
    {
        $this->tableau_commentaires = $tableau_commentaires;
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