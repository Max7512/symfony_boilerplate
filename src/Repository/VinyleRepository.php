<?php

namespace App\Repository;

use App\Entity\Vinyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Vinyle>
 */
class VinyleRepository extends ServiceEntityRepository
{
    public ?PaginatorInterface $paginator = null;
    public ?Request $request = null;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Vinyle::class);
        $this->paginator = $paginator;
    }

    public function getAll(?string $search = null): array
    {
        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle";
        if ($search != null) {
            $dql .= " JOIN vinyle.author as author WHERE vinyle.deleted = false AND vinyle.name LIKE :search OR author.name LIKE :search";
        } else {
            $dql .= " WHERE vinyle.deleted = false";
        }
        $query = $this->getEntityManager()->createQuery($dql);

        if ($search != null) {
            $query->setParameter('search', '%' . $search . '%');
        }

        // parameters to template
        return $query->getResult();
    }

    public function getAllPaginate(int $page = 1, ?string $search = null, ?int $pageLimit = 25): PaginationInterface
    {
        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle";
        if ($search != null) {
            $dql .= " JOIN vinyle.author as author WHERE vinyle.deleted = false vinyle.name LIKE :search OR author.name LIKE :search";
        } else {
            $dql .= " WHERE vinyle.deleted = false";
        }
        $query = $this->getEntityManager()->createQuery($dql);

        if ($search != null) {
            $query->setParameter('search', '%' . $search . '%');
        }

        $pagination = $this->paginator->paginate(
            $query,
            $page,
            $pageLimit
        );

        // parameters to template
        return $pagination;
    }

    //    /**
    //     * @return Vinyle[] Returns an array of Vinyle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vinyle
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
