<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * SubFamily
 *
 * @ORM\Table(name="sub_family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubFamilyRepository")
 */
class SubFamily
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Family", inversedBy="subFamilies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Genus", mappedBy="subFamily")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genera;

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(
     * max = 255,)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @return mixed
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param mixed $family
     * @return SubFamily
     */
    public function setFamily($family)
    {
        $this->family = $family;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenera()
    {
        return $this->genera;
    }

    /**
     * @param mixed genera
     * @return SubFamily
     */
    public function setGenera($genera)
    {
        $this->genera = $genera;
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
     * @return SubFamily
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
     * @return SubFamily
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
        $this->genera = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add genus
     *
     * @param \AppBundle\Entity\Genus $genus
     *
     * @return SubFamily
     */
    public function addGenus(\AppBundle\Entity\Genus $genus)
    {
        $this->genera[] = $genus;
        return $this;
    }

    /**
     * Remove genus
     *
     * @param \AppBundle\Entity\Genus $genus
     */
    public function removeGenus(\AppBundle\Entity\Genus $genus)
    {
        $this->genera->removeElement($genus);
    }

    /**
     * Add genera
     *
     * @param \AppBundle\Entity\Genus $genera
     * @return SubFamily
     */
    public function addGenera(\AppBundle\Entity\Genus $genera)
    {
        $this->genera[] = $genera;
        return $this;
    }

    /**
     * Remove genera
     *
     * @param \AppBundle\Entity\Genus $genera
     */
    public function removeGenera(\AppBundle\Entity\Genus $genera)
    {
        $this->genera->removeElement($genera);
    }

    public function fullName()
    {
        return $this->getName();
    }
}
