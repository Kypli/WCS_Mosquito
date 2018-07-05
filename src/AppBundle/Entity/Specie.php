<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Specie
 *
 * @ORM\Table(name="specie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecieRepository")
 */
class Specie
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Genus", inversedBy="species")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genus;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Specimen", mappedBy="specie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specimens;

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(
     * max = 255,)
     * @Assert\NotBlank
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     * @return Specie
     */
    public function setName($name)
    {
        $name = strtolower($name);
        $this->name = ucfirst($name);
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return strtolower($this->name) ;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->specimens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add specimen
     *
     * @param \AppBundle\Entity\Specimen $specimen
     * @return Specie
     */
    public function addSpecimen(\AppBundle\Entity\Specimen $specimen)
    {
        $this->specimens[] = $specimen;
        return $this;
    }

    /**
     * Remove specimen
     *
     * @param \AppBundle\Entity\Specimen $specimen
     */
    public function removeSpecimen(\AppBundle\Entity\Specimen $specimen)
    {
        $this->specimens->removeElement($specimen);
    }

    /**
     * Get specimens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecimens()
    {
        return $this->specimens;
    }


    public function specieName()
    {
        return $this->getName();
    }
    /**
     * Set genus
     *
     * @param \AppBundle\Entity\Genus $genus
     *
     * @return Specie
     */
    public function setGenus(\AppBundle\Entity\Genus $genus)
    {
        $this->genus = $genus;

        return $this;
    }

    /**
     * Get genus
     *
     * @return \AppBundle\Entity\Genus
     */
    public function getGenus()
    {
        return $this->genus;
    }
}
