<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Specie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Specie controller.
 *
 * @Route("specie")
 */
class SpecieController extends Controller
{
    /**
     * Lists all specie entities.
     *
     * @Route("/", name="specie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        // Search Species
        $em = $this->getDoctrine()->getManager();
        $species = $em->getRepository('AppBundle:Specie')->findAll();

        // Create Button Delete
        $deleteForms = [];
        foreach ($species as $specie) {
            $deleteForm = $this->createDeleteForm($specie)->createView();
            $deleteForms[$specie->getId()] = $deleteForm;
        }

        return $this->render('specie/index.html.twig', array(
            'species' => $species,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new specie entity.
     *
     * @Route("/new", name="specie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specie = new Specie();
        $form = $this->createForm('AppBundle\Form\SpecieType', $specie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specie);
            $em->flush();

            return $this->redirectToRoute('specie_index');
        }

        return $this->render('specie/new.html.twig', array(
            'specie' => $specie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specie entity.
     *
     * @Route("/{id}/edit", name="specie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Specie $specie, SessionInterface $session)
    {
        $deleteForm = $this->createDeleteForm($specie);
        $editForm = $this->createForm('AppBundle\Form\SpecieType', $specie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $session->getFlashBag()->add('edit_specie', 'Species has been edited !');
            return $this->redirectToRoute('specie_edit', array('id' => $specie->getId()));
        }

        return $this->render('specie/edit.html.twig', array(
            'specie' => $specie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specie entity.
     *
     * @Route("/{id}", name="specie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Specie $specie)
    {
        $form = $this->createDeleteForm($specie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specie);
            $em->flush();
            $this->addFlash('success', 'Species has been deleted !');
        }

        return $this->redirectToRoute('specie_index');
    }

    /**
     * Creates a form to delete a specie entity.
     *
     * @param Specie $specie The specie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specie $specie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specie_delete', array('id' => $specie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
