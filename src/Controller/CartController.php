<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
final class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(CartService $cartService, int $id): Response
    {
        $cartService->addProduct($id);

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease(CartService $cartService, int $id): Response
    {
        $cartService->decreaseProduct($id);

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function remove(CartService $cartService, int $id): Response
    {
        $cartService->removeProducts($id);

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/clear', name: 'app_cart_clear')]
    public function clear(CartService $cartService, int $id): Response
    {
        $cartService->clear();

        return $this->redirectToRoute('app_cart_index');
    }
}
