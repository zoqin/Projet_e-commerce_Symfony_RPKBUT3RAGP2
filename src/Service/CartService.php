<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private RequestStack $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $request, ProductRepository $productRepository) {
        $this->requestStack = $request;
        $this->productRepository = $productRepository;
    }

    public function getSession() {
        $session = $this->requestStack->getSession();
    }

    public function addProduct(int $id) {
        $cart = $this->getSession()->get("cart", []);

        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $this->getSession()->set("cart", $cart);
    }

    public function decreaseProduct(int $id) {
        $cart = $this->getSession()->get("cart", []);

        if(!empty($cart[$id])) {
            if($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
    }

    public function removeProducts(int $id) {
        $cart = $this->getSession()->get("cart", []);

        if(!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $this->getSession()->set("cart", $cart);
    }

    public function clear() {
        $this->getSession()->remove("cart");
    }

    public function getCart() {
        $cart = $this->getSession()->get("cart", []);
        $cartData = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if($product) {
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            } else {
                $this->removeProducts($id);
            }
        }

        return $cartData;
    }

    public function getTotal() {
        $total = 0;

        foreach($this->getCart() as $item) {
            $total += $item['quantity'] * $item['product']->getPrice();
        }

        return $total;
    }
}