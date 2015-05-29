<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Mammals;
use AppBundle\Form\MammalsType;

/**
 * Mammals controller.
 *
 * @Route("/admin/mammals")
 */
class MammalsController extends Controller
{

    /**
     * Lists all Mammals entities.
     *
     * @Route("/", name="admin_mammals")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Mammals')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Mammals entity.
     *
     * @Route("/", name="admin_mammals_create")
     * @Method("POST")
     * @Template("AppBundle:Mammals:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mammals();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_mammals_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Mammals entity.
     *
     * @param Mammals $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mammals $entity)
    {
        $form = $this->createForm(new MammalsType(), $entity, array(
            'action' => $this->generateUrl('admin_mammals_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mammals entity.
     *
     * @Route("/new", name="admin_mammals_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mammals();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mammals entity.
     *
     * @Route("/{id}", name="admin_mammals_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Mammals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mammals entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mammals entity.
     *
     * @Route("/{id}/edit", name="admin_mammals_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Mammals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mammals entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Mammals entity.
    *
    * @param Mammals $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mammals $entity)
    {
        $form = $this->createForm(new MammalsType(), $entity, array(
            'action' => $this->generateUrl('admin_mammals_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mammals entity.
     *
     * @Route("/{id}", name="admin_mammals_update")
     * @Method("PUT")
     * @Template("AppBundle:Mammals:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Mammals')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mammals entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_mammals_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mammals entity.
     *
     * @Route("/{id}", name="admin_mammals_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Mammals')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mammals entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_mammals'));
    }

    /**
     * Creates a form to delete a Mammals entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_mammals_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
