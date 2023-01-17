<?php


class Studio
{
    private $id;
    private $nom;
    private $argent;

    public function __construct($id, $nom, $argent)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->argent = $argent;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($nom)
    {
        $this->nom = $nom;
    }

    public function getName()
    {
        return $this->nom;
    }

    public function setargent($argent)
    {
        $this->argent = $argent;
    }

    public function getargent()
    {
        return $this->argent;
    }
}