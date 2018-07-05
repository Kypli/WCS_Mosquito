<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SimpleSearch
{
    /**
     * @var SearchInterface
     */
    private $searchInterface;

    /**
     * @var SessionControl
     */
    private $sessionControl;

    /**
     * SimpleSearch constructor.
     * @param SessionControl $sessionControl
     * @param SearchInterface $searchInterface
     */
    public function __construct(SessionControl $sessionControl, SearchInterface $searchInterface)
    {
        $this->sessionControl = $sessionControl;
        $this->searchInterface = $searchInterface;
    }

    public function results(string $request, SessionInterface $session)
    {
        // Control session
        $this->sessionControl->searchOrderBy($session);

        // Search
        $results = $this->searchInterface->search(
            $request,
            $session->get('orderBy'),
            $session->get('orderByDirection')
        );

        // No result ?
        if (empty($results)) {
            $session->getFlashBag()->add('error', 'No results found !');
            $results = null;
        }

        return $results;
    }
}