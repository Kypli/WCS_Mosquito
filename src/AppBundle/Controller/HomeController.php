<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use AppBundle\Service\SimpleSearch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 *
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, SessionInterface $session, SimpleSearch $simpleSearch)
    {
        // Initialize Render
        $formSearch = null;
        $results = null;

        // Initialize Form SimpleSearch
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        // SimpleSearch
        if ($form->isSubmitted() && $form->isValid()) {

            // Request
            $formSearch = $search->getSearch();
            $results = $simpleSearch->results($formSearch, $session);

        // BackSearch
        } elseif (!empty($request->query->get('backSearch'))) {

            // Request
            $formSearch = $request->query->get('backSearch');
            $results = $simpleSearch->results($formSearch, $session);

        // OrderBy
        } elseif (!empty($request->query->get('search'))) {

            // Put OrderBy in Session
            $session->set('orderBy', $request->query->get('orderBy'));
            $session->set('orderByDirection', $request->query->get('orderByDirection'));

            // Request
            $formSearch = $request->query->get('search');
            $results = $simpleSearch->results($formSearch, $session);
        }

        // Paginator
        if ($results != null) {
            $paginator  = $this->get('knp_paginator');
            $results = $paginator->paginate(
                $results, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $this->getParameter('max_item_pagination')
            );
        }

        return $this->render(
            'default/index.html.twig', [
                'results' => $results,
                'search' => $formSearch,
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction()
    {
        // Display form
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        return $this->render(
            'default/form.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }
}
