<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{


    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return $this->render('product/product.html.twig', ['product' => $product]);
    }

 

    #[Route('/sortprice/{price}', name: 'sort_price')]
    public function showByPrice(int $price, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAllGreaterThanPrice($price);

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
    #[Route('/create', name: 'create')]
    #[Route('/update/{id}', name: 'update')]
    public function update(Product $product=null, Request $request, EntityManagerInterface $emi): Response
    {
        if(!$product) {
            $product = new Product();
        }
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $emi->persist($product);
            $emi->flush();
            return $this->redirectToRoute('product_index');
        }
            
        return $this->render('product/productForm.html.twig', ['formProduct'=>$form->createView()]);
    }
}
