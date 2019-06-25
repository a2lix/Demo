<?php

declare(strict_types=1);

namespace App\Controller\BackendCustom;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\GenericDeleteType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company", name="backend_company_")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('backend/company/index.html.twig', ['companies' => $companyRepository->findAll()]);
    }

    /**
     * @Route("/new", name="new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            $this->addFlash('success', 'Created!');

            return $this->redirectToRoute('backend_company_index');
        }

        return $this->render('backend/company/new_edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods="GET")
     */
    public function show(Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company, [
            'action' => $this->generateUrl('backend_company_delete', ['id' => $company->getId()]),
        ]);

        return $this->render('backend/company/show.html.twig', [
            'company' => $company,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods="GET|POST")
     */
    public function edit(Request $request, Company $company): Response
    {
        // // AutoForm example
        // $form = $this->createForm(\A2lix\AutoFormBundle\Form\Type\AutoFormType::class, $company, [
        //     'action' => $this->generateUrl($_route, ['id' => $company->getId()]),
        // ])->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Edited!');

            return $this->redirectToRoute('backend_company_edit', ['id' => $company->getId()]);
        }

        $deleteForm = $this->createForm(GenericDeleteType::class, $company, [
            'action' => $this->generateUrl('backend_company_delete', ['id' => $company->getId()]),
        ]);

        return $this->render('backend/company/new_edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods="DELETE")
     */
    public function delete(Request $request, Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('backend_company_index');
    }
}
