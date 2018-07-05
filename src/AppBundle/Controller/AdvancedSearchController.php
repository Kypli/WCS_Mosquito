<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use AppBundle\Entity\Specimen;
use AppBundle\Service\AdvanceSearch;
use AppBundle\Form\SearchAdvancedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Class AdvancedSearchController
 *
 * @package AppBundle\Controller
 */
class AdvancedSearchController extends Controller
{
    /**
     * @Route("/asearch", name="asearch")
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aSearchAction(Request $request, SessionInterface $session, AdvanceSearch $advanceSearch)
    {
        // Initialize Render
        $results = null;
        $deleteForms = null;

        // Initialize Form
        $search = new Search();
        $form = $this->createForm(SearchAdvancedType::class, $search);
        $form->handleRequest($request);

        // Advance Search
        if ($form->isSubmitted() && $form->isValid()) {

            // Request
            $results = $advanceSearch->results($search, $session);

            // Results ?
            if ($results != null) {

                // Delete button
                $deleteForms = [];
                foreach ($results as $specimen) {
                    $deleteForm = $this->createDeleteForm($specimen)->createView();
                    $deleteForms[$specimen->getId()] = $deleteForm;
                }

                // Paginator
                $paginator  = $this->get('knp_paginator');
                $results = $paginator->paginate(
                    $results, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $this->getParameter('max_item_pagination_thumb')
                );

            }

        }

        return $this->render(
            'default/asearch.html.twig', [
                'specimens' => $results,
                'form' => $form->createView(),
                'deleteForms' => $deleteForms,
            ]
        );

    }

    /**
     * Creates a form to delete a specimen entity.
     *
     * @param Specimen $specimen The specimen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specimen $specimen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specimen_delete', array('id' => $specimen->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
