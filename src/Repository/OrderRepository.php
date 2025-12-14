<?php

namespace App\Repository;

use App\Entity\Order;
use App\Enum\OrderStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getTotalSalesByMonth(): array
    {
        return $this->createQueryBuilder('o')
            ->select('YEAR(o.createdAt) as year')
            ->addSelect('MONTH(o.createdAt) as month')
            ->addSelect('SUM(oi.quantity * oi.productPrice) as totalSales')
            ->leftJoin('o.orderItem', 'oi')
            ->where('o.status = :status')
            ->setParameter('status', OrderStatus::LIVREE)
            ->groupBy('year', 'month')
            ->orderBy('year', 'DESC')
            ->addOrderBy('month', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
