<?php


class Chiot
{
    public $idChiot;
    public $nomChiot;
    public $sexeChiot;

    /**
     * Chiot constructor.
     * @param $idChiot
     * @param $nomChiot
     * @param $sexeChiot
     */
    public function __construct($idChiot, $nomChiot, $sexeChiot)
    {
        $this->idChiot = $idChiot;
        $this->nomChiot = $nomChiot;
        $this->sexeChiot = $sexeChiot;
    }

    /**
     * @return mixed
     */
    public function getIdChiot()
    {
        return $this->idChiot;
    }

    /**
     * @param mixed $idChiot
     */
    public function setIdChiot($idChiot)
    {
        $this->idChiot = $idChiot;
    }

    /**
     * @return mixed
     */
    public function getNomChiot()
    {
        return $this->nomChiot;
    }

    /**
     * @param mixed $nomChiot
     */
    public function setNomChiot($nomChiot)
    {
        $this->nomChiot = $nomChiot;
    }

    /**
     * @return mixed
     */
    public function getSexeChiot()
    {
        return $this->sexeChiot;
    }

    /**
     * @param mixed $sexeChiot
     */
    public function setSexeChiot($sexeChiot)
    {
        $this->sexeChiot = $sexeChiot;
    }




}