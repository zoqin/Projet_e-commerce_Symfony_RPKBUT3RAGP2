<?php

namespace App\Twig\Components;

use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ProductSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable:true, url: true)]
    public string $query = '';

    public function __construct(private ProductRepository $productRepository) {}

    public function getProducts(): array
    {
        if (empty($this->query)) {
            return $this->productRepository->findBy([], ['id' => 'DESC'], 10);
        }

        return $this->productRepository
            ->createQueryBuilder('p')
            ->where('p.name LIKE :query')
            ->setParameter('query', '%' . $this->query . '%')
            ->getQuery()
            ->getResult();
    }
}
