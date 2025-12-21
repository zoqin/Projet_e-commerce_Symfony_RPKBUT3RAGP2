<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        CategoryRepository $categoryRepository,
        Request $request,
    ): Response
    {
        $categories = $categoryRepository->findAll();
        $selectedCategoryIds = $request->query->all()['categories'] ?? [];

        if(empty($selectedCategoryIds)) {
            $data = $productRepository->findBy([], ['id' => 'DESC']);
        } else {
            $data = $productRepository->findByCategories($selectedCategoryIds);
        }

        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            9
        );


        return $this->render('index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategories' => $selectedCategoryIds,
        ]);
    }

}