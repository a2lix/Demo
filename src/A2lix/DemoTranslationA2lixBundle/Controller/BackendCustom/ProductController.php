<?php

namespace A2lix\DemoTranslationA2lixBundle\Controller\BackendCustom;

use A2lix\CommonBundle\Form\Type\DeleteType;
use A2lix\DemoTranslationA2lixBundle\Entity\Product;
use A2lix\DemoTranslationA2lixBundle\Form\ProductType;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine as A2lixI18nDoctrine;
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
     * @Route("/", defaults={"id"=""}, name="a2lix_backend_product")
     * @Route("/{id}/show", name="a2lix_backend_product_show")
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationA2lixBundle:Product')->find($id)) {
                throw $this->createNotFoundException();
            }

            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('a2lix_backend_product_delete', ['id' => $id]),
            ]);

            return $this->render('demo_translation/a2lix/backend_custom/product/show.html.twig', [
                'entity' => $entity,
                'deleteForm' => $deleteForm->createView(),
            ]);
        }

        return $this->render('demo_translation/a2lix/backend_custom/product/index.html.twig', [
            'entities' => $em->getRepository('A2lixDemoTranslationA2lixBundle:Product')->findAll(),
        ]);
    }

    /**
     * New/Edit.
     *
     * @A2lixI18nDoctrine
     * @Route("/new", defaults={"id"=""}, name="a2lix_backend_product_new")
     * @Route("/{id}/edit", name="a2lix_backend_product_edit")
     */
    public function editAction(Request $request, $_route, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationA2lixBundle:Product')->find($id)) {
                throw $this->createNotFoundException();
            }
            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('a2lix_backend_product_delete', ['id' => $id]),
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

            return $this->redirectToRoute('a2lix_backend_product_show', ['id' => $entity->getId()]);
        }

        return $this->render('demo_translation/a2lix/backend_custom/product/edit.html.twig', [
            'entity' => $entity,
            'editForm' => $editForm->createView(),
        ] + ($id ? ['deleteForm' => $deleteForm->createView()] : []));
    }

    /**
     * Delete.
     *
     * @Route("/{id}/delete", name="a2lix_backend_product_delete", options={"i18n" = false})
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

        return $this->redirectToRoute('a2lix_backend_product');
    }
}
