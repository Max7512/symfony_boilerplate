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

    public function getVinylesStatusCounts(): array
    {
        $dql = "SELECT
                    SUM(CASE WHEN vinyle.status = 'En stock' THEN 1 ELSE 0 END) as in_stock,
                    SUM(CASE WHEN vinyle.status = 'En rupture de stock' THEN 1 ELSE 0 END) as out_of_stock,
                    SUM(CASE WHEN vinyle.status = 'En précommande' THEN 1 ELSE 0 END) as preorder
                FROM App\Entity\Vinyle vinyle";
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getSingleResult();
    }


    public function getOutOfStock(): array
    {
        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle WHERE vinyle.status = 'En rupture de stock'";
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }


    public function getAll(?string $search = null): array
    {
        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle";
        if ($search != null) {
            $dql .= " JOIN vinyle.author as author WHERE vinyle.deleted = false AND (vinyle.name LIKE :search OR author.name LIKE :search)";
        } else {
            $dql .= " WHERE vinyle.deleted = false";
        }
        $query = $this->getEntityManager()->createQuery($dql);

        if ($search != null) {
            $query->setParameter('search', '%' . $search . '%');
        }

        return $query->getResult();
    }

    public function getAllPaginate(int $page = 1, ?string $search = null, ?int $pageLimit = 25): PaginationInterface
    {
        $dql = "SELECT vinyle FROM App\Entity\Vinyle vinyle";
        if ($search != null) {
            $dql .= " JOIN vinyle.author as author WHERE vinyle.deleted = false AND (vinyle.name LIKE :search OR author.name LIKE :search)";
        } else {
            $dql .= " WHERE vinyle.deleted = false";
        }
        $query = $this->getEntityManager()->createQuery($dql);

        if ($search != null) {
            $query->setParameter('search', '%' . $search . '%');
        }

        if (!$this->paginator) {
            throw new \LogicException('The paginator service is not available. Try running "composer require knplabs/knp-paginator-bundle"');
        }

        $pagination = $this->paginator->paginate(
            $query,
            $page,
            $pageLimit
        );

        return $pagination;
    }
}
