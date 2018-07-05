<?php

namespace AppBundle\Service;

class SessionControl
{

    /**
     * @param $session
     */
    public function searchOrderBy($session)
    {
        // Empty ?
        if (empty($session->get('orderBy')) || empty($session->get('orderByDirection'))) {
            $session->set('orderBy', 'family');
            $session->set('orderByDirection', 'ASC');
        }

        // Session['orderBy']
        if (!in_array($session->get('orderBy'), ['family','subFamily','genus','specie'])) {
            $session->set('orderBy', 'family');
        }

        // Session['orderByDirection']
        if (!in_array($session->get('orderByDirection'), ['ASC','DESC'])) {
            $session->set('orderByDirection', 'ASC');
        }

    }
}