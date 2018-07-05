<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Specimen
 *
 * @ORM\Table(name="specimen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecimenRepository")
 * @Vich\Uploadable
 */
class Specimen
{

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Specie", inversedBy="specimens")
     */
    private $specie;

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
     * @Assert\Length(min=2, max="255")
     * @Assert\Length(
     * max = 255,)
     * @Assert\NotBlank
     *
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="gpsLatitude", type="float")
     * @Assert\Type(type="float")
     */
    private $gpsLatitude;

    /**
     * @var float
     *
     * @ORM\Column(name="gpsLongitude", type="float")
     * @Assert\Type(type="float")
     */
    private $gpsLongitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trueCoordinate", type="boolean")
     */
    private $trueCoordinate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\Date()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\Length(min="2", max="255")
     *
     */
    private $author;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="specimen_image", fileNameProperty="imageName", size="imageSize")
     * @Assert\Image(
     *     maxSize="2M",
     *     maxSizeMessage="Ce fichier est trop grand, la limite est de 2 Mo.",
     *     uploadIniSizeErrorMessage="Ce fichier est trop grand, la limite est de 2 Mo.",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage="Le fichier envoyé doit être une image.",
     *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque.",
     *     uploadErrorMessage = "Erreur durant l'envoi du fichier.",
     * )
     * @Assert\Expression("this.getImageFile() or this.getImageName()", message="Vous devez envoyer une image.")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    private $description;

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
     *
     * @return Specimen
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gpsLatitude
     *
     * @param float $gpsLatitude
     *
     * @return Specimen
     */
    public function setGpsLatitude($gpsLatitude)
    {
        $this->gpsLatitude = $gpsLatitude;

        return $this;
    }

    /**
     * Get gpsLatitude
     *
     * @return float
     */
    public function getGpsLatitude()
    {
        return $this->gpsLatitude;
    }

    /**
     * Set gpsLongitude
     *
     * @param float $gpsLongitude
     *
     * @return Specimen
     */
    public function setGpsLongitude($gpsLongitude)
    {
        $this->gpsLongitude = $gpsLongitude;

        return $this;
    }

    /**
     * Get gpsLongitude
     *
     * @return float
     */
    public function getGpsLongitude()
    {
        return $this->gpsLongitude;
    }

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Specimen
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Specimen
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Specimen
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Specimen
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set trueCoordinate
     *
     * @param mixed $trueCoordinate
     *
     * @return Specimen
     */
    public function setTrueCoordinate($trueCoordinate)
    {
        $this->trueCoordinate = $trueCoordinate;

        return $this;
    }

    /**
     * Get trueCoordinate
     *
     * @return mixed
     */
    public function getTrueCoordinate()
    {
        return $this->trueCoordinate;
    }

    /**
     * Set specie
     *
     * @param \AppBundle\Entity\Specie $specie
     *
     * @return Specimen
     */
    public function setSpecie($specie)
    {
        $this->specie = $specie;

        return $this;
    }

    /**
     * Get specie
     *
     * @return \AppBundle\Entity\Specie
     */
    public function getSpecie()
    {
        return $this->specie;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Specimen
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Specimen
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param integer $imageSize
     *
     * @return Specimen
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Specimen
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
