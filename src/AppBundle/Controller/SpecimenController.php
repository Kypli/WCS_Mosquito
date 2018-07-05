<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Specimen;
use AppBundle\Repository\SpecieRepository;
use AppBundle\Repository\SpecimenRepository;
use SensioLabs\Security\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Specimen controller.
 * Class SpecimenController
 *
 * @Route("specimen")
 * @package AppBundle\Controller
 */
class SpecimenController extends Controller
{

    /**
     * @param Request $request
     * @param $name
     * @return JsonResponse
     * @Route ("/list/{name}", name="list-specimen")
     *
     */
    public function autocompleteAction(Request $request, $name)
    {
        if ($request->isXmlHttpRequest()) {
            /**
             * @var $repository SpecimenRepository
             */
            $max_result = $this->getParameter('max_result');
            $em =  $this->getDoctrine();
            $data['family'] = $em->getRepository('AppBundle:Family')->getFamilyLike($name,$max_result);
            $data['subFamily'] = $em->getRepository('AppBundle:SubFamily')->getSubFamilyLike($name,$max_result);
            $data['genus'] = $em->getRepository('AppBundle:Genus')->getGenusLike($name,$max_result);
            $data['specie'] = $em->getRepository('AppBundle:Specie')->getSpecieLike($name,$max_result);
            $data['specimen'] = $em->getRepository('AppBundle:Specimen')->getSpecimenLike($name,$max_result);
            return new JsonResponse(array("data" => json_encode($data)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    /**
     * @param Request $request
     * @param $name
     * @return JsonResponse
     * @Route ("/new/list/{name}", name="new_list_specimen")
     *
     */
    public function autocompleteSpecimenAction(Request $request, $name)
    {
        if ($request->isXmlHttpRequest()) {
            /**
             * @var $repository SpecieRepository
             */
            $max_result = $this->getParameter('max_result');
            $em =  $this->getDoctrine();
            $data = $em->getRepository('AppBundle:Specie')->getGenusSpecieLike($name,$max_result);
            return new JsonResponse(array("data" => json_encode($data)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    /**
     * Lists all specimen entities.
     *
     * @Route("/",    name="specimen_index")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, SessionInterface $session)
    {
        // Doctrine
        $em = $this->getDoctrine()->getManager();

        // Initialize Session
        if (!empty($request->query->get('specie'))) {
            $session->set('specie', $request->query->get('specie'));
            $session->set('gender', $request->query->get('gender'));
            $session->set('backSearch', $request->query->get('backSearch'));
        }

        // Back Homepage
        if ($session->get('specie') == null) {
            return $this->redirectToRoute('homepage');
            die;
        }

        // Specie
        $specie = $em->getRepository('AppBundle:Specie')
            ->findBy(['name' => $session->get('specie')], array(), null, 0);

        // Thumbnail's list
        $specimens = $em->getRepository('AppBundle:Specimen')
            ->findThumbnail(
                $specie[0]->getGenus()->getSubFamily()->getFamily()->getName(),
                $specie[0]->getGenus()->getSubFamily()->getName(),
                $specie[0]->getGenus()->getName(),
                $specie[0]->getName(),
                $session->get('gender')
            );

        // Delete button
        $deleteForms = [];
        foreach ($specimens as $specimen) {
            $deleteForm = $this->createDeleteForm($specimen)->createView();
            $deleteForms[$specimen->getId()] = $deleteForm;
        }

        // Paginator
        $paginator  = $this->get('knp_paginator');
        $specimens = $paginator->paginate(
            $specimens, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('max_item_pagination_thumb')
        );

        return $this->render('specimen/index.html.twig', array(
            'specimens' => $specimens,
            'deleteForms' => $deleteForms,
        ));

    }

    /**
     * Creates a new specimen entity.
     *
     * @Route("/new", name="specimen_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, SessionInterface $session)
    {
        $user = $this->getUser();
        $specimen = new Specimen();
        $form = $this->createForm('AppBundle\Form\SpecimenType', $specimen);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specimen);
            $em->flush();
            $session->set('specie', $specimen->getSpecie()->getName());
            $session->set('gender', $specimen->getGender());
            $session->set('specie', $specimen->getSpecie()->getName());
            $session->set('gender', $specimen->getGender());

            return $this->redirectToRoute('specimen_show', array('id' => $specimen->getId()));
        }

        return $this->render('specimen/new.html.twig', array(
            'specimen' => $specimen,
            'form' => $form->createView(),
            'user'=>$user,
        ));
    }

    /**
     * Finds and displays a specimen entity.
     *
     * @Route("/{id}", name="specimen_show")
     * @Method("GET")
     * @param Specimen $specimen
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Specimen $specimen)
    {
        $deleteForm = $this->createDeleteForm($specimen);

        return $this->render(
            'specimen/show.html.twig', array(
                'specimen' => $specimen,
                'delete_form' => $deleteForm->createView(),
            )
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

    /**
     * Displays a form to edit an existing specimen entity.
     *
     * @Route("/{id}/edit", name="specimen_edit")
     * @Method({"GET",      "POST"})
     * @param Request $request
     * @param Specimen $specimen
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Specimen $specimen, SessionInterface $session)
    {
        $deleteForm = $this->createDeleteForm($specimen);
        $editForm = $this->createForm('AppBundle\Form\SpecimenEditType', $specimen);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addFlash('success', 'Specimen has been edited !');
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specimen_edit', array('id' => $specimen->getId()));
        }

        return $this->render(
            'specimen/edit.html.twig', array(
                'specimen' => $specimen,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a specimen entity.
     *
     * @Route("/{id}",   name="specimen_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Specimen $specimen
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Specimen $specimen)
    {
        $form = $this->createDeleteForm($specimen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specimen);
            $em->flush();
            $this->addFlash('success', 'Specimen has been deleted !');
        }

        return $this->redirectToRoute('specimen_index');
    }

}
