<?php

namespace App\Twig\Components;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ProductSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable:true, url: true)]
    public string $query = '';

    #[LiveProp(writable:true, url: true)]
    public array $selectedCategories = [];

    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
    ) {}

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getProducts(): array
    {
        if (empty($this->query)) {
            return $this->productRepository->findBy([], ['id' => 'DESC'], 10);
        }

        $qb = $this->productRepository->createQueryBuilder('p');

        if(!empty($this->query)) {
            $qb->andWhere('p.name LIKE :query')
                ->setParameter('query', '%'.$this->query.'%');
        }

        if(!empty($this->selectedCategories)) {
            $qb->join('p.category', 'c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $this->selectedCategories);
        }

        return $qb->orderBy('p.id', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }
}
