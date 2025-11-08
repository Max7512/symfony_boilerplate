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

    public function getAllPaginate(Request $request, ?string $search = null, ?int $pageLimit = null): PaginationInterface
    {
        if ($pageLimit == null) {
            $pageLimit = 25;
        }

        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle";
        if ($search != null) {
            $dql .= " JOIN vinyle.author as author WHERE vinyle.name LIKE :search OR author.name LIKE :search";
        }
        $query = $this->getEntityManager()->createQuery($dql);

        if ($search != null) {
            $query->setParameter('search', '%' . $search . '%');
        }

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
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
