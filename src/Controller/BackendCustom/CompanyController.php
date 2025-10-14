<?php

declare(strict_types=1);

namespace App\Controller\BackendCustom;

use A2lix\AutoFormBundle\Form\Type\AutoType;
use A2lix\AutoFormBundle\Attribute\AutoTypeIgnore;
use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\DateRangeType;
use App\Form\GenericDeleteType;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/{_locale}/backend/company', name: 'backend_company_')]
class CompanyController extends AbstractController
{
    public function __construct(
        private readonly ManagerRegistry $managerRegistry,
    ) {}

    #[Route(path: '/', name: 'index', methods: 'GET')]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('backend/company/index.html.twig', ['companies' => $companyRepository->findAll()]);
    }

    #[Route(path: '/new', name: 'new', methods: 'GET|POST')]
    public function new(Request $request): Response
    {        
        $company = new Company();

        // $form = $this->createForm(AutoType::class, new Dto(child: new DtoChild()), [
        // $form = $this->createForm(AutoType::class, null, [ 'data_class' => Dto::class,
        $form = $this->createForm(AutoType::class, $company, [
        // $form = $this->container->get('form.factory')
        //     ->createNamed('fff', AutoType::class, $company, [
                'children' => [
                    // 'name' => fn (FormBuilderInterface $builder) => $builder->create('name', CheckboxType::class),
                    'date_range' => [
                        'child_excluded' => true,
                        'mapped' => false,
                    ],

                    'save' => [
                        'child_type' => SubmitType::class,
                        'label' => 'Go!',
                    ],
                ],
                'children_embedded' => '*',
                // 'builder' => static fn (FormBuilderInterface $builder, $props) => $builder->remove('code'),
            ])
            ->handleRequest($request)
        ;
        // $form = $this->createForm(CompanyType::class, $company)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $em = $this->managerRegistry->getManager();
            // $em->persist($company);
            // $em->flush();

            dump($form->getData());

            $this->addFlash('success', 'Created!');

            // return $this->redirectToRoute('backend_company_index');
        }

        return $this->render('backend/company/new_edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'show', methods: 'GET')]
    public function show(Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company, [
            'action' => $this->generateUrl('backend_company_delete', ['id' => $company->getId()]),
        ]);

        return $this->render('backend/company/show.html.twig', [
            'company' => $company,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'edit', methods: 'GET|POST')]
    public function edit(Request $request, Company $company, $_route): Response
    {
        // // AutoForm example
        // $form = $this->createForm(AutoType::class, $company, [
        //     'action' => $this->generateUrl($_route, ['id' => $company->getId()]),
        // ])->add('save', SubmitType::class);
        $form = $this->createForm(CompanyType::class, $company)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();

            $this->addFlash('success', 'Edited!');

            return $this->redirectToRoute('backend_company_edit', ['id' => $company->getId()]);
        }

        $deleteForm = $this->createForm(GenericDeleteType::class, $company, [
            'action' => $this->generateUrl('backend_company_delete', ['id' => $company->getId()]),
        ]);

        return $this->render('backend/company/new_edit.html.twig', [
            'company' => $company,
            'form' => $form,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Request $request, Company $company): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $company)->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->managerRegistry->getManager();
            $em->remove($company);
            $em->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('backend_company_index');
    }
}

class Dto {
    /**
     * @param Collection<int, DtoChildAlt> $coll
     * @param list<int> $labels
     * @param list<ProductStatus> $status
     */
    public function __construct(
        public  DtoChild $child,
        public  ?string $id = null,
        public  ?string $name = null,
        private  ?int $code = null,
        public  ?\DateTimeImmutable $startAt = null,
        public  ?\DateTimeImmutable $endAt = null,
        public ?Collection $coll = null,
        public  ?array $labels = null,
        // public  ?ProductStatus $status = null,
        public ?array $status = null,
    ) {
        $this->coll ??= new ArrayCollection();
    }

    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
}

 class DtoChild {
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }
}

 class DtoChildAlt {
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }
}

enum ProductStatus
{
    case Available;
    case Unavailable;
}
