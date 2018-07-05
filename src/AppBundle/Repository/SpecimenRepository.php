<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Search;


/**
 * Class SpecimenRepository
 * @package AppBundle\Repository
 */
class SpecimenRepository extends EntityRepository
{
    /**
     * @param $input
     * @param $category
     * @param $orderBy
     * @return array
     */
    public function findSimpleSearch($input, $category, $orderBy)
    {
        $query = $this->createQueryBuilder('specimen')
            ->join('specimen.specie', 'specie')
            ->join('specie.genus', 'genus')
            ->join('genus.subFamily', 'subFamily')
            ->join('subFamily.family', 'family')
            ->where('specimen.name=:input or specie.name=:input or genus.name=:input or subFamily.name=:input or family.name=:input' )
            ->setParameter('input', $input)
            ->orderBy($category.'.name', $orderBy)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $family
     * @param $subFamily
     * @param $genus
     * @param $specie
     * @param $gender
     * @return array
     */
    public function findThumbnail($family, $subFamily, $genus, $specie, $gender)
    {
        $query = $this->createQueryBuilder('specimen')
            ->join('specimen.specie', 'specie')
            ->join('specie.genus', 'genus')
            ->join('genus.subFamily', 'subFamily')
            ->join('subFamily.family', 'family')
            ->where('specimen.gender=:gender and specie.name=:specie and genus.name=:genus and subFamily.name=:subFamily and family.name=:family' )
            ->setParameter('family', $family)
            ->setParameter('subFamily', $subFamily)
            ->setParameter('genus', $genus)
            ->setParameter('specie', $specie)
            ->setParameter('gender', $gender)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param Search $search
     * @return array
     */
    public function findAdvancedSearch(Search $search)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.name LIKE :input')
            ->setParameter('input', '%' . $search->getName() . '%');

        if (!empty($search->getDate())) {
            $query->andWhere('s.date >= :date')
                  ->setParameter('date', $search->getDate());
        }

        if (!empty($search->getAuthor())) {
            $query->andWhere('s.author = :author')
                  ->setParameter('author', $search->getAuthor());
        }

        if (!empty($search->getGpsLatitude()) && !empty($search->getGpsLongitude())) {
            $query
            ->andWhere('s.gpsLongitude BETWEEN :gpsLongitudeMinus AND :gpsLongitudePlus')
            ->andWhere('s.gpsLatitude BETWEEN :gpsLatitudeMinus AND :gpsLatitudePlus')
                ->setParameter('gpsLatitudeMinus',  $search->getGpsLatitude()-5)
                ->setParameter('gpsLatitudePlus',  $search->getGpsLatitude()+5)
                ->setParameter('gpsLongitudeMinus',  $search->getGpsLongitude()-5)
                ->setParameter('gpsLongitudePlus', $search->getGpsLongitude()+5);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param $name
     * @param $max_result
     * @return array
     */
    public function getSpecimenLike($name, $max_result)
    {
        $name =  "%" . $name . "%";

        $qb = $this->createQueryBuilder('n')
            ->select('n.name')
            ->where('n.name LIKE :name')
            ->setParameter('name', $name)
            ->setMaxResults($max_result)
            ->getQuery();

        return $qb->getResult();

    }

}
