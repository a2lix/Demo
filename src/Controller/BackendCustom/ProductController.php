<?php

declare(strict_types=1);

namespace App\Controller\BackendCustom;

use A2lix\AutoFormBundle\Form\Type\AutoType;
use App\Entity\Product;
use App\Entity\ProductMedia;
use App\Form\GenericDeleteType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/{_locale}/backend/product', name: 'backend_product_')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductRepository $productRepository, 
    ) {}

    #[Route(path: '/', name: 'index', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('backend/product/index.html.twig', [
            'productColl' => $this->productRepository->findAll(),
        ]);
    }

    #[Route(path: '/man/new', name: 'newMan', methods: 'GET|POST')]
    #[Route(path: '/man/{id}/edit', name: 'editMan', methods: 'GET|POST')]
    public function newEditManual(
        Request $request,
        #[MapEntity(expr: 'repository.findOneWithTranslation(id)')] ?Product $product,
    ): Response {
        $product = $product ?? new Product();
        $form = $this->createForm(ProductType::class, $product)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->addFlash('success', 'Created!');

            return $this->redirectToRoute('backend_product_index');
        }

        return $this->render('backend/product/new_edit.html.twig', [
            'form' => $form,
            'product' => $product,
        ]);
    }

    #[Route(path: '/auto/new', name: 'newAuto', methods: 'GET|POST')]
    #[Route(path: '/auto/{id}/edit', name: 'editAuto', methods: 'GET|POST')]
    public function newEditAuto(
        Request $request,
        #[MapEntity(expr: 'repository.findOneWithTranslation(id)')] ?Product $product,
    ): Response {
        $product = $product ?? new Product();
        $form = $this
            ->createForm(AutoType::class, $product, [
                'children_embedded' => '*',
            ])->add('save', SubmitType::class, [
                'label' => null !== $product ? 'Edit' : 'Create',
                'attr' => [
                    'class' => 'btn-primary btn-lg btn-block',
                ],
            ])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->addFlash('success', 'Created!');

            return $this->redirectToRoute('backend_product_index');
        }

        return $this->render('backend/product/new_edit.html.twig', [
            'form' => $form,
            'product' => $product,
        ]);
    }

    #[Route(path: '/{id}', name: 'show', methods: 'GET')]
    public function show(Product $product): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $product, [
            'action' => $this->generateUrl('backend_product_delete', ['id' => $product->id]),
        ]);

        return $this->render('backend/product/show.html.twig', [
            'product' => $product,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Request $request, Product $product): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $product)->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('backend_product_index');
    }
}
