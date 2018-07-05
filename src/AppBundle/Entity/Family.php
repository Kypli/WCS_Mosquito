<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Family
 *
 * @ORM\Table(name="family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FamilyRepository")
 */
class Family
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SubFamily", mappedBy="family")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subFamilies;

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
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(
     * max = 255,)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @return mixed
     */
    public function getSubFamilies()
    {
        return $this->subFamilies;
    }

    /**
     * @param mixed $subFamilies
     * @return Family
     */
    public function setSubFamilies($subFamilies)
    {
        $this->subFamilies = $subFamilies;
        return $this;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     * @param int $id
     * @return Family
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return ucfirst($this->name);
    }

    /**
     * Set name
     * @param string $name
     * @return Family
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
        $this->subFamilies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subFamily
     * @param \AppBundle\Entity\SubFamily $subFamily
     * @return Family
     */
    public function addSubFamily(\AppBundle\Entity\SubFamily $subFamily)
    {
        $this->subFamilies[] = $subFamily;
        return $this;
    }

    /**
     * Remove subFamily
     * @param \AppBundle\Entity\SubFamily $subFamily
     * @return subFamily
     */
    public function removeSubFamily(\AppBundle\Entity\SubFamily $subFamily)
    {
        $this->subFamilies->removeElement($subFamily);
        return ucfirst($this->name);
    }

    public function fullName()
    {
        return $this->getName();
    }
}
