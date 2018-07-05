<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Genus controller.
 *
 * @Route("genus")
 */
class GenusController extends Controller
{
    /**
     * Lists all genus entities.
     *
     * @Route("/", name="genus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        // Search Genus
        $em = $this->getDoctrine()->getManager();
        $genera = $em->getRepository('AppBundle:Genus')->findAll();

        // Create Button Delete
        $deleteForms = [];
        foreach ($genera as $genus) {
            $deleteForm = $this->createDeleteForm($genus)->createView();
            $deleteForms[$genus->getId()] = $deleteForm;
        }

        return $this->render('genus/index.html.twig', array(
            'genera' => $genera,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new genus entity.
     *
     * @Route("/new", name="genus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $genus = new Genus();
        $form = $this->createForm('AppBundle\Form\GenusType', $genus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();

            return $this->redirectToRoute('genus_index');
        }

        return $this->render('genus/new.html.twig', array(
            'genus' => $genus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing genus entity.
     *
     * @Route("/{id}/edit", name="genus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Genus $genus, SessionInterface $session)
    {
        $deleteForm = $this->createDeleteForm($genus);
        $editForm = $this->createForm('AppBundle\Form\GenusType', $genus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $session->getFlashBag()->add('edit_genus', 'Genus has been edited !');
            return $this->redirectToRoute('genus_edit', array('id' => $genus->getId()));
        }

        return $this->render('genus/edit.html.twig', array(
            'genus' => $genus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a genus entity.
     *
     * @Route("/{id}", name="genus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Genus $genus)
    {
        $form = $this->createDeleteForm($genus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($genus);
            $em->flush();
            $this->addFlash('success', 'Genus has been deleted !');
        }

        return $this->redirectToRoute('genus_index');
    }

    /**
     * Creates a form to delete a genus entity.
     *
     * @param Genus $genus The genus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genus $genus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('genus_delete', array('id' => $genus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
