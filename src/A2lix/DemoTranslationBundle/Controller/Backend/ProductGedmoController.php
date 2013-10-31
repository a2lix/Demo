<?php

namespace A2lix\DemoTranslationBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\HttpFoundation\Request;
use A2lix\DemoTranslationBundle\Entity\ProductGedmo;
use A2lix\DemoTranslationBundle\Form\ProductGedmoType;

/**
 * @Route("/product/gedmo")
 */
class ProductGedmoController extends Controller
{
    /**
     * Show one/list
     *
     * @Route("/", defaults={"id"=""}, name="backend_productGedmo")
     * @Route("/{id}/show", name="backend_productGedmo_show")
     * @Template
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:ProductGedmo')->find($id)) {
                throw $this->createNotFoundException();
            }

            $deleteForm = $this->createForm('delete', $entity, array(
                'action' => $this->generateUrl('backend_productGedmo_delete', array('id' => $id))
            ));
            
            return $this->render("A2lixDemoTranslationBundle:Backend\\ProductGedmo:show.html.twig", array(
                'entity'     => $entity,
                'deleteForm' => $deleteForm->createView()
            ));
        }

        return array(
            'entities' => $em->getRepository('A2lixDemoTranslationBundle:ProductGedmo')->findAll()
        );
    }

    /**
     * New/Edit
     *
     * @Route("/new", defaults={"id"=""}, name="backend_productGedmo_new")
     * @Route("/{id}/edit", name="backend_productGedmo_edit")
     * @Template
     */
    public function editAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:ProductGedmo')->find($id)) {
                throw $this->createNotFoundException();
            }
            $deleteForm = $this->createForm('delete', $entity, array(
                'action' => $this->generateUrl('backend_productGedmo_delete', array('id' => $id))
            ));

        } else {
            $entity = new ProductGedmo();
        }

        $editForm = $this->createForm(new ProductGedmoType(), $entity, array(
            'action' => $this->generateUrl($request->attributes->get('_route'), array('id' => $id))
        ));
        if ($editForm->handleRequest($request)->isSubmitted() && $editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_productGedmo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'   => $entity,
            'editForm' => $editForm->createView()
        ) + ($id ? array('deleteForm' => $deleteForm->createView()) : array());
    }

    /**
     * Delete
     *
     * @Route("/{id}/delete", name="backend_productGedmo_delete", options={"i18n" = false})
     * @Method("POST")
     */
    public function deleteAction(Request $request, ProductGedmo $entity)
    {
        $deleteForm = $this->createForm('delete', $entity);

        if ($deleteForm->handleRequest($request)->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            $this->get('bc_bootstrap.flash')->success('Deleted!');
        }
        
        return $this->redirect($this->generateUrl('backend_productGedmo'));
    }
}