<?php

namespace A2lix\DemoTranslationBundle\Controller\BackendCustom;

use A2lix\CommonBundle\Form\Type\DeleteType;
use A2lix\DemoTranslationBundle\Entity\Company;
use A2lix\DemoTranslationBundle\Form\CompanyType;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine as A2lixI18nDoctrine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * A2lixI18n version
 *
 * @Route("/company")
 */
class CompanyController extends Controller
{
    /**
     * Show one/list.
     *
     * @Method("GET")
     * @Route("/", defaults={"id"=""}, name="a2lix_backend_company")
     * @Route("/{id}/show", name="a2lix_backend_company_show")
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:Company')->find($id)) {
                throw $this->createNotFoundException();
            }

            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('a2lix_backend_company_delete', ['id' => $id]),
            ]);

            return $this->render('demo_translation/backend/company/show.html.twig', [
                'entity' => $entity,
                'deleteForm' => $deleteForm->createView(),
            ]);
        }

        return $this->render('demo_translation/backend/company/index.html.twig', [
            'entities' => $em->getRepository('A2lixDemoTranslationBundle:Company')->findAll(),
        ]);
    }

    /**
     * New/Edit.
     *
     * @A2lixI18nDoctrine
     * @Route("/new", defaults={"id"=""}, name="a2lix_backend_company_new")
     * @Route("/{id}/edit", name="a2lix_backend_company_edit")
     */
    public function editAction(Request $request, $_route, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (!$entity = $em->getRepository('A2lixDemoTranslationBundle:Company')->find($id)) {
                throw $this->createNotFoundException();
            }
            $deleteForm = $this->createForm(DeleteType::class, $entity, [
                'action' => $this->generateUrl('a2lix_backend_company_delete', ['id' => $id]),
            ]);
        } else {
            $entity = new Company();
        }

        $editForm = $this->createForm(CompanyType::class, $entity, [
            'action' => $this->generateUrl($_route, $id ? ['id' => $id] : []),
        ]);

//        $editForm = $this->createForm(\A2lix\AutoFormBundle\Form\Type\AutoFormType::class, $entity, [
//            'action' => $this->generateUrl($_route, $id ? ['id' => $id] : []),
//        ])
//            ->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);

        if ($editForm->handleRequest($request)->isSubmitted() && $editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('a2lix_backend_company_show', ['id' => $entity->getId()]);
        }

        return $this->render('demo_translation/backend/company/edit.html.twig', [
            'entity' => $entity,
            'editForm' => $editForm->createView(),
        ] + ($id ? ['deleteForm' => $deleteForm->createView()] : []));
    }

    /**
     * Delete.
     *
     * @Route("/{id}/delete", name="a2lix_backend_company_delete", options={"i18n" = false})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Company $entity)
    {
        $deleteForm = $this->createForm(DeleteType::class, $entity);

        if ($deleteForm->handleRequest($request)->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('a2lix_backend_company');
    }
}
