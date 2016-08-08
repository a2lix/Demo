<?php

namespace A2lix\DemoTranslationBundle\Controller\BackendCustom;

use A2lix\CommonBundle\Form\Type\DeleteType;
use A2lix\DemoTranslationBundle\Entity\Product;
use A2lix\DemoTranslationBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Show one/list.
     *
     * @Method("GET")
     * @Route("/", defaults={"id"=""}, name="knp_backend_product")
     * @Route("/{id}/show", name="knp_backend_product_show")
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:Product')->find($id)) {
                throw $this->createNotFoundException();
            }

            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('knp_backend_product_delete', ['id' => $id]),
            ]);

            return $this->render('demo_translation/backend/product/show.html.twig', [
                'entity' => $entity,
                'deleteForm' => $deleteForm->createView(),
            ]);
        }

        return $this->render('demo_translation/backend/product/index.html.twig', [
            'entities' => $em->getRepository('A2lixDemoTranslationBundle:Product')->findAll(),
        ]);
    }

    /**
     * New/Edit.
     *
     * @Route("/new", defaults={"id"=""}, name="knp_backend_product_new")
     * @Route("/{id}/edit", name="knp_backend_product_edit")
     */
    public function editAction(Request $request, $_route, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:Product')->find($id)) {
                throw $this->createNotFoundException();
            }
            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('knp_backend_product_delete', ['id' => $id]),
            ]);
        } else {
            $entity = new Product();
        }

        $editForm = $this->createForm(ProductType::class, $entity, [
            'action' => $this->generateUrl($_route, $id ? ['id' => $id] : []),
        ]);
        if ($editForm->handleRequest($request)->isSubmitted() && $editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('knp_backend_product_show', ['id' => $entity->getId()]);
        }

        return $this->render('demo_translation/backend/product/edit.html.twig', [
            'entity' => $entity,
            'editForm' => $editForm->createView(),
        ] + ($id ? ['deleteForm' => $deleteForm->createView()] : []));
    }

    /**
     * Delete.
     *
     * @Route("/{id}/delete", name="knp_backend_product_delete", options={"i18n" = false})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $entity)
    {
        $deleteForm = $this->createForm(DeleteType::class, $entity);

        if ($deleteForm->handleRequest($request)->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('knp_backend_product');
    }
}
