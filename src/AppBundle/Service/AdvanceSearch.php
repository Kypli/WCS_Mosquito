<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManager;


class AdvanceSearch
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * AdvanceSearch constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $search
     * @return null
     */
    public function results($search, SessionInterface $session)
    {
        // Search
        $results = $this
            ->em
            ->getRepository('AppBundle:Specimen')
            ->findAdvancedSearch($search);

        // No result ?
        if (empty($results)) {
            $session->getFlashBag()->add('error', 'No results found !');
            $results = null;
        }

        return $results;
    }
}
