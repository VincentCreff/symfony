<?php

namespace App\Controller;

use App\Entity\ShoppingCart;
use App\Form\ShoppingCartType;
use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/shopping-cart')]
class ShoppingCartController extends AbstractController
{
    #[Route('/', name: 'app_shopping_cart_index', methods: ['GET'])]
    public function index(ShoppingCartRepository $shoppingCartRepository): Response
    {
        return $this->render('shopping_cart/index.html.twig', [
            'shopping_carts' => $shoppingCartRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shopping_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShoppingCartRepository $shoppingCartRepository): Response
    {
        $shoppingCart = new ShoppingCart();
        $form = $this->createForm(ShoppingCartType::class, $shoppingCart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $shoppingCartRepository->add($shoppingCartRepository->getTotalShoppingCart($shoppingCart), true);

            return $this->redirectToRoute('app_shopping_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shopping_cart/new.html.twig', [
            'shopping_cart' => $shoppingCart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shopping_cart_show', methods: ['GET'])]
    public function show(ShoppingCart $shoppingCart): Response
    {
        return $this->render('shopping_cart/show.html.twig', [
            'shopping_cart' => $shoppingCart,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shopping_cart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ShoppingCart $shoppingCart, ShoppingCartRepository $shoppingCartRepository): Response
    {
        $form = $this->createForm(ShoppingCartType::class, $shoppingCart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shoppingCartRepository->add($shoppingCartRepository->getTotalShoppingCart($shoppingCart), true);

            return $this->redirectToRoute('app_shopping_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shopping_cart/edit.html.twig', [
            'shopping_cart' => $shoppingCart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shopping_cart_delete', methods: ['POST'])]
    public function delete(Request $request, ShoppingCart $shoppingCart, ShoppingCartRepository $shoppingCartRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shoppingCart->getId(), $request->request->get('_token'))) {
            $shoppingCartRepository->remove($shoppingCart, true);
        }

        return $this->redirectToRoute('app_shopping_cart_index', [], Response::HTTP_SEE_OTHER);
    }
}
