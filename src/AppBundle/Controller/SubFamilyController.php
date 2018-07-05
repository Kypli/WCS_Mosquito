<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SubFamily;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Subfamily controller.
 *
 * @Route("subfamily")
 */
class SubFamilyController extends Controller
{
    /**
     * Lists all subFamily entities.
     *
     * @Route("/", name="subfamily_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        // Search SubFamilies
        $em = $this->getDoctrine()->getManager();
        $subFamilies = $em->getRepository('AppBundle:SubFamily')->findBy([], ['family' => 'DESC']);

        // Create Button Delete
        $deleteForms = [];
        foreach ($subFamilies as $subFamily) {
            $deleteForm = $this->createDeleteForm($subFamily)->createView();
            $deleteForms[$subFamily->getId()] = $deleteForm;
        }

        return $this->render('subfamily/index.html.twig', array(
            'subFamilies' => $subFamilies,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new subFamily entity.
     *
     * @Route("/new", name="subfamily_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $subFamily = new Subfamily();
        $form = $this->createForm('AppBundle\Form\SubFamilyType', $subFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subFamily);
            $em->flush();

            return $this->redirectToRoute('subfamily_index');
        }

        return $this->render('subfamily/new.html.twig', array(
            'subFamily' => $subFamily,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subFamily entity.
     *
     * @Route("/{id}/edit", name="subfamily_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SubFamily $subFamily, SessionInterface $session)
    {
        $deleteForm = $this->createDeleteForm($subFamily);
        $editForm = $this->createForm('AppBundle\Form\SubFamilyType', $subFamily);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $session->getFlashBag()->add('edit_subfamily', 'Subfamily has been edited !');
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('subfamily_edit', array('id' => $subFamily->getId()));
        }

        return $this->render('subfamily/edit.html.twig', array(
            'subFamily' => $subFamily,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subFamily entity.
     *
     * @Route("/{id}", name="subfamily_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SubFamily $subFamily)
    {
        $form = $this->createDeleteForm($subFamily);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subFamily);
            $em->flush();
            $this->addFlash('success', 'Subfamily has been deleted !');
        }

        return $this->redirectToRoute('subfamily_index');
    }

    /**
     * Creates a form to delete a subFamily entity.
     *
     * @param SubFamily $subFamily The subFamily entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SubFamily $subFamily)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subfamily_delete', array('id' => $subFamily->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

