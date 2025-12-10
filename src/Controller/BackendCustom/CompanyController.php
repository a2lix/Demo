<?php declare(strict_types=1);

namespace App\Controller\BackendCustom;

use A2lix\AutoFormBundle\Form\Type\AutoType;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\GenericDeleteType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/backend/company', name: 'backend_company_')]
class CompanyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CompanyRepository $companyRepository,
    ) {}

    #[Route(path: '/', name: 'index', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('backend/company/index.html.twig', [
            'companyColl' => $this->companyRepository->findAll(),
        ]);
    }

    #[Route(path: '/man/new', name: 'newMan', methods: 'GET|POST')]
    #[Route(path: '/man/{id}/edit', name: 'editMan', methods: 'GET|POST')]
    #[Route(path: '/auto/new', name: 'newAuto', methods: 'GET|POST')]
    #[Route(path: '/auto/{id}/edit', name: 'editAuto', methods: 'GET|POST')]
    public function newEditAuto(
        Request $request,
        ?Company $company,
        string $_route,
    ): Response {
        $company ??= new Company();

        $form = (
            str_ends_with($_route, 'Man')
                ? $this->createForm(CompanyType::class, $company)
                : $this
                    ->createForm(AutoType::class, $company)
                    ->add('save', SubmitType::class, [
                        'label' => null !== $company ? 'Edit' : 'Create',
                        'attr' => ['class' => 'btn-primary btn-lg btn-block'],
                    ])
        )->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($company);
            $this->entityManager->flush();

            $this->addFlash('success', 'Created!');

            return $this->redirectToRoute('backend_company_index');
        }

        return $this->render('backend/company/new_edit.html.twig', [
            'form' => $form,
            'company' => $company,
        ]);
    }

    #[Route(path: '/{id}', name: 'show', methods: 'GET')]
    public function show(Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company, [
            'action' => $this->generateUrl('backend_company_delete', ['id' => $company->id]),
        ]);

        return $this->render('backend/company/show.html.twig', [
            'company' => $company,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Request $request, Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company)->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $this->entityManager->remove($company);
            $this->entityManager->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('backend_company_index');
    }
}
