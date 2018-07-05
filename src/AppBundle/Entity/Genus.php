<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Genus
 *
 * @ORM\Table(name="genus")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusRepository")
 */
class Genus
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubFamily", inversedBy="genera")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subFamily;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Specie", mappedBy="genus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $species;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(
     * max = 255,)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @return mixed
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }

    /**
     * @param mixed $subFamily
     * @return Genus
     */
    public function setSubFamily($subFamily)
    {
        $this->subFamily = $subFamily;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @param mixed $species
     * @return Genus
     */
    public function setSpecies($species)
    {
        $this->species = $species;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return Genus
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return genus
     */
    public function setName($name)
    {
        $name = strtolower($name);
        $this->name = ucfirst($name);
        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->species = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add specie
     *
     * @param \AppBundle\Entity\Specie $specie
     *
     * @return Genus
     */
    public function addSpecie(\AppBundle\Entity\Specie $specie)
    {
        $this->species[] = $specie;
        return $this;
    }

    /**
     * Remove specie
     *
     * @param \AppBundle\Entity\Specie $specie
     */
    public function removeSpecie(\AppBundle\Entity\Specie $specie)
    {
        $this->species->removeElement($specie);
    }

    /**
     * Add species
     *
     * @param \AppBundle\Entity\Specie $species
     *
     * @return Genus
     */
    public function addSpecy(\AppBundle\Entity\Specie $species)
    {
        $this->species[] = $species;
        return $this;
    }

    /**
     * Remove species
     *
     * @param \AppBundle\Entity\Specie $species
     */
    public function removeSpecy(\AppBundle\Entity\Specie $species)
    {
        $this->species->removeElement($species);
        return ucfirst( $this->name);
    }

    public function fullName()
    {
        return $this->getName();
    }
}
