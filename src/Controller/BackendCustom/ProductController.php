<?php

declare(strict_types=1);

namespace App\Controller\BackendCustom;

use App\Entity\Product;
use App\Form\GenericDeleteType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/{_locale}/backend/product', name: 'backend_product_')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ManagerRegistry $managerRegistry,
    ) {}

    #[Route(path: '/', name: 'index', methods: 'GET')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('backend/product/index.html.twig', ['products' => $productRepository->findAll()]);
    }

    #[Route(path: '/new', name: 'new', methods: 'GET|POST')]
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->managerRegistry->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Created!');

            return $this->redirectToRoute('backend_product_index');
        }

        return $this->render('backend/product/new_edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'show', methods: 'GET')]
    public function show(Product $product): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $product, [
            'action' => $this->generateUrl('backend_product_delete', ['id' => $product->getId()]),
        ]);

        return $this->render('backend/product/show.html.twig', [
            'product' => $product,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'edit', methods: 'GET|POST')]
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->managerRegistry->getManager()->flush();

            $this->addFlash('success', 'Edited!');

            return $this->redirectToRoute('backend_product_edit', ['id' => $product->getId()]);
        }

        $deleteForm = $this->createForm(GenericDeleteType::class, $product, [
            'action' => $this->generateUrl('backend_product_delete', ['id' => $product->getId()]),
        ]);

        return $this->render('backend/product/new_edit.html.twig', [
            'product' => $product,
            'form' => $form,
            'deleteForm' => $deleteForm,
        ]);
    }

    #[Route(path: '/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(Request $request, Product $product): Response
    {
        $deleteForm = $this->createForm(GenericDeleteType::class, $product)->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->managerRegistry->getManager();
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', 'Deleted!');
        }

        return $this->redirectToRoute('backend_product_index');
    }
}
