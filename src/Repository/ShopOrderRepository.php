<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ShopOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShopOrder>
 */
final class ShopOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopOrder::class);
    }

    public function getShopOrderByNumber(string $orderNumber): ?ShopOrder
    {
        return $this->createQueryBuilder('so')
            ->where('so.orderNumber = :number')
            ->setParameter('number', $orderNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
