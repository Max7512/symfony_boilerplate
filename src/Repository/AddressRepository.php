<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function getUserAdresses(int $userId): array
    {
        $dql = "SELECT adresse FROM App\Entity\Address adresse JOIN adresse.user user WHERE user.id = :userId AND adresse.deleted = 0";

        $query = $this->getEntityManager()->createQuery($dql);

        $query->setParameter('userId', $userId);

        return $query->getResult();
    }
}
