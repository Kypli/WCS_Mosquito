<?php

namespace AppBundle\Entity;


/**
 * Class Search
 *
 * @package AppBundle\Entity
 */
class Search
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     *
     */
    private $search;

    /**
     * @var double
     */
    private $date;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $gpsLatitude;

    /**
     * @var float
     */
    private $gpsLongitude;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Search
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param float $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return float
     */
    public function getGpsLatitude()
    {
        return $this->gpsLatitude;
    }

    /**
     * @param float $gpsLatitude
     */
    public function setGpsLatitude($gpsLatitude)
    {
        $this->gpsLatitude = $gpsLatitude;
    }

    /**
     * @return float
     */
    public function getGpsLongitude()
    {
        return $this->gpsLongitude;
    }

    /**
     * @param float $gpsLongitude
     */
    public function setGpsLongitude($gpsLongitude)
    {
        $this->gpsLongitude = $gpsLongitude;
    }

    /**
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param string $search
     * @return Search
     */
    public function setSearch($search)
    {
        $this->search = $search;
        return $this;
    }

}
