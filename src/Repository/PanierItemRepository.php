<?php

namespace App\Repository;

use App\Entity\PanierItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PanierItem>
 */
class PanierItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PanierItem::class);
    }

    public function getUserPanier(int $userId): array {
        $dql = "SELECT panierItem FROM App\Entity\PanierItem panierItem JOIN panierItem.User user WHERE user.id = :userId";

        $query = $this->getEntityManager()->createQuery($dql);

        $query->setParameter('userId', $userId);

        return $query->getResult();
    }

    public function getUserPanierTotal(int $userId): float {
        $dql = "SELECT SUM(vinyle.price * panierItem.quantity) total FROM App\Entity\PanierItem panierItem JOIN panierItem.User as user JOIN panierItem.Vinyle as vinyle WHERE user.id = :userId";

        $query = $this->getEntityManager()->createQuery($dql);

        $query->setParameter('userId', $userId);

        $total = 0;

        $result = $query->getResult();

        if (count($result) > 0) {
            $total = $result[0]["total"];
        } 

        return $total;
    }
}
