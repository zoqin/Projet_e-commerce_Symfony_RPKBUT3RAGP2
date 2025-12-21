<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Enum\OrderStatus;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    public function clear(CartService $cartService): Response
    {
        $cartService->clear();

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/validate', name: 'app_cart_validate')]
    #[IsGranted('ROLE_USER')]
    public function validate(CartService $cartService, EntityManagerInterface $entityManager): Response
    {
        $cart = $cartService->getCart();

        if(empty($cart)) {
            $this->addFlash('warning', "Votre panier est vide");
            return $this->redirectToRoute('app_cart_index');
        }

        $order = new Order($this->getUser());
        $order->setStatus(OrderStatus::PREPARATION);

        $entityManager->persist($order);

        foreach ($cart as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if($product->getStock() < $quantity) {
                $this->addFlash(
                    'warning',
                    $product->getName()." n'a plus assez de stock (Dispo : ".$product->getStock().")"
                );

                return $this->redirectToRoute('app_cart_index');
            }

            $product->setStock($product->getStock() - $quantity);

            $orderItem = new OrderItem($product);
            $orderItem->setQuantity($quantity);
            $orderItem->setOrderEntity($order);

            $entityManager->persist($orderItem);
        }

        $entityManager->flush();

        $cartService->clear();
        $this->addFlash('success', 'Votre commande a été validé avec succès');

        return $this->redirectToRoute('app_cart_index');
    }
}
