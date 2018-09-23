<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeerRepository")
 * @ORM\Table(name="beers")
 */
class Beer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $pricePerLitre;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Brewer", inversedBy="beers")
     * @ORM\JoinColumn(name="brewer", referencedColumnName="id")
     */
    private $brewer;

    public function __construct($name, $pricePerLitre, $country, $type, $brewer) {
        $this->name = $name;
        $this->pricePerLitre = $pricePerLitre;
        $this->country = $country;
        $this->type = $type;
        $this->brewer = $brewer;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPricePerLitre()
    {
        return $this->pricePerLitre;
    }

    /**
     * @param mixed $pricePerLitre
     */
    public function setPricePerLitre($pricePerLitre): void
    {
        $this->pricePerLitre = $pricePerLitre;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getBrewer() : Brewer
    {
        return $this->brewer;
    }

    /**
     * @param mixed $brewer
     */
    public function setBrewer($brewer): void
    {
        $this->brewer = $brewer;
    }




}
