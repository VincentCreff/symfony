<?php

namespace App\Controller;


use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    #[Route('/add/{id}', name: 'app_product_add')]
    public function addProduct(int $id, SessionInterface $session){
        $shoppingCart = $session->get('shoppingCart',[]);
        if(!empty($shoppingCart[$id])){
            $shoppingCart[$id]++;
    } else {
        $shoppingCart[$id] = 1;
    }
    $session->set('shoppingCart',$shoppingCart);
    return $this->redirectToRoute('app_index');
    }

    #[Route('/cart', name: 'app_cart')]
    public function showCart(ProductRepository $productRepository, SessionInterface $session){
        $shoppingCart = $session->get('shoppingCart',[]);
$shoppingCartWithData = [];
foreach($shoppingCart as $id => $quantity){
    $shoppingCartWithData[] = [
        'product' => $productRepository->find($id),
        'quantity' => $quantity];}
dd($shoppingCartWithData);

       return $this->render('cart.html.twig', [
        'cartItems' => $shoppingCartWithData
    ]);

}}
