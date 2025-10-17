<?php

namespace App\Repository;

use App\Entity\Burger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @extends ServiceEntityRepository<Burger>
 */
class BurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Burger::class);
    }

    public function findBurgersWithIngredient(string $ingredient): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT burger
             FROM App\Entity\Burger burger
             JOIN burger.ingredients ingredients
             WHERE LOWER(ingredients.name) = LOWER(:ingredient)"
        );

        $query->setParameter('ingredient', $ingredient);

        return $query->getResult();
    }

    public function findTopXBurgers(int $topx): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT burger
             FROM App\Entity\Burger burger
             ORDER BY burger.price DESC"
        );
        
        $query->setMaxResults($topx);

        return $query->getResult();
    }
}
