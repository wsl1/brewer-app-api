<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\BrewerRepository")
 * @ORM\Table(name="brewers")
 */
class Brewer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Beer", mappedBy="brewer")
     * @ORM\JoinColumn(name="beer", referencedColumnName="id")
     */
    private $beers;

    public function __construct($name)
    {
        $this->beers = new ArrayCollection();
        $this->name = $name;
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
    public function getBeers(): ?Collection
    {
        return $this->beers;
    }

    /**
     * @param mixed $beers
     */
    public function setBeers($beers): void
    {
        $this->beers = $beers;
    }
}
