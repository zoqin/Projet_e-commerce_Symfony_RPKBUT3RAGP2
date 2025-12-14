<?php

namespace App\Controller;

use App\Enum\ProductStatus;
use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
    ): Response
    {
        $fiveLastOrders = $orderRepository->findBy([], ['createdAt' => 'DESC'], 5);

        $productInStock = $productRepository->count(['status' => ProductStatus::DISPONIBLE]);
        $productOutOfOrder = $productRepository->count(['status' => ProductStatus::RUPTURE]);
        $productPreorder = $productRepository->count(['status' => ProductStatus::PRECOMMANDE]);

        $totalProduct = $productInStock + $productOutOfOrder + $productPreorder;

        $ratioInStock = $totalProduct > 0 ? round(($productInStock / $totalProduct) * 100) : 0;
        $ratioOutOfOrder = $totalProduct > 0 ? round(($productOutOfOrder / $totalProduct) * 100) : 0;
        $ratioPreorder = $totalProduct > 0 ? round(($productPreorder / $totalProduct) * 100) : 0;

        $categories = $categoryRepository->findAll();
        $categoriesStats = [];
        foreach ($categories as $category) {
            $count = $category->getProducts()->count();

            $categoriesStats[] = [
                'name' => $category->getName(),
                'count' => $count,
            ];
        }

        $totalSalesByMonth = $orderRepository->getTotalSalesByMonth();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'fiveLastOrders' => $fiveLastOrders,
            'totalProduct' => $totalProduct,
            'totalSalesByMonth' => $totalSalesByMonth,
            'statusStats' => [
                'count' => [
                    'inStock' => $productInStock,
                    'outOfOrder' => $productOutOfOrder,
                    'preorder' => $productPreorder
                ],
                'ratio' => [
                    'inStock' => $ratioInStock,
                    'outOfOrder' => $ratioOutOfOrder,
                    'preorder' => $ratioPreorder
                ]
            ],
            'categoriesStats' => $categoriesStats,
        ]);
    }
}
