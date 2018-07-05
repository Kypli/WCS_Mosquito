<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Family controller.
 * Class CategoryController
 *
 * @package AppBundle\Controller
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * @param Request $request
     * Lists all family, subfamilies entities, genus entities, species entities.
     *
     * @Route("/",    name="category_index")
     * @Method("GET")
     * @return        \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->getForm($request);
        $families = $em->getRepository('AppBundle:Family')
            ->findAll();
        $subFamilies = $em->getRepository('AppBundle:SubFamily')
            ->findAll();
        $genera = $em->getRepository('AppBundle:Genus')
            ->findAll();
        $species = $em->getRepository('AppBundle:Specie')
            ->findAll();
        return $this->render(
            'category/index.html.twig', array(
                'families' => $families,
                'subFamilies' => $subFamilies,
                'genera' => $genera,
                'species' => $species,
                'form' => $form->createView(),)
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        return $form;
    }
}
