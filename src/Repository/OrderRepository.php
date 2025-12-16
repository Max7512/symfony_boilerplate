<?php

namespace App\Repository;

use App\Entity\Order;
use App\Util\OrderStatus;
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

    public function getSalesByMonth(): array
    {
        $dql = "SELECT SUBSTRING(o.createdAt, 1, 7) as sales_month, SUM(orderItem.quantity * orderItem.productPrice) as total_revenue
                FROM App\Entity\OrderItem orderItem
                JOIN orderItem.Order_ o
                WHERE o.status = :status
                GROUP BY sales_month
                ORDER BY sales_month DESC";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('status', OrderStatus::DELIVERED);

        return $query->getResult();
    }
}
