<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Family;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Family controller.
 * Class FamilyController
 *
 * @Route("family")
 * @package AppBundle\Controller
 */
class FamilyController extends Controller
{
    /**
     * Lists all family entities.
     *
     * @Route("/", name="family_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        // Search Families
        $em = $this->getDoctrine()->getManager();
        $families = $em->getRepository('AppBundle:Family')->findBy([], ['name' => 'ASC']);

        // Create delete button
        $deleteForms = [];
        foreach ($families as $family) {
            $deleteForm = $this->createDeleteForm($family)->createView();
            $deleteForms[$family->getId()] = $deleteForm;
        }

        return $this->render('family/index.html.twig', array(
            'families' => $families,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new family entity.
     *
     * @Route("/new", name="family_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $family = new Family();
        $newform = $this->createForm('AppBundle\Form\FamilyType', $family);
        $newform->handleRequest($request);

        if ($newform->isSubmitted() && $newform->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($family);
            $em->flush();

            return $this->redirectToRoute('family_index');
        }

        return $this->render('family/new.html.twig', array(
            'family' => $family,
            'newform' => $newform->createView(),
        ));
    }

    /**
     * Creates a form to delete a family entity.
     * @param Family $family The family entity
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Family $family)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('family_delete', array('id' => $family->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing family entity.
     *
     * @Route("/{id}/edit", name="family_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Family $family, SessionInterface $session)
    {
        $deleteForm = $this->createDeleteForm($family);
        $editForm = $this->createForm('AppBundle\Form\FamilyType', $family);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $session->getFlashBag()->add('edit_family', 'Family has been edited !');
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('family_edit', array('id' => $family->getId()));
        }

        return $this->render('family/edit.html.twig', array(
            'family' => $family,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a family entity.
     *
     * @Route("/{id}", name="family_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Family $family)
    {
        $newForm = $this->createDeleteForm($family);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($family);
            $em->flush();
            $this->addFlash('success', 'Family has been deleted !');
        }

        return $this->redirectToRoute('family_index');
    }
}
