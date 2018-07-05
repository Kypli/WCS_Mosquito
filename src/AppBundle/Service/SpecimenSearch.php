<?php

namespace AppBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

/**
 * Class SpecimenSearch
 * @package AppBundle\Service
 */
class SpecimenSearch implements SearchInterface
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var SpecimenToResult
     */
    private $specimentToResult;

    /**
     * SpecimenSearch constructor.
     * @param EntityManager $em
     * @param SpecimenToResult $specimenToResult
     */
    public function __construct(EntityManager $em, SpecimenToResult $specimenToResult)
    {
        $this->em = $em;
        $this->specimentToResult = $specimenToResult;
    }

    /**
     * Perform a search in database and call SpecimenToResult service to calculate some datas.
     *
     * @param string $subject
     * @return array
     */
    public function search(string $subject, string $category, string $orderBy): array
    {
        $results = [];
        $resultsDb = $this->em
            ->getRepository('AppBundle:Specimen')
            ->findSimpleSearch($subject, $category, $orderBy);

        if (!empty($resultsDb)) {
            $results = $this->specimentToResult->convertSpecimen($resultsDb);
        }

        return $results;
    }
}
