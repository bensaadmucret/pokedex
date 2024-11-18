<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;



/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    } 

    public function createFilteredQueryBuilder(
        ?string $search = null,
        ?string $type = null,
        string $sortBy = 'name',
        string $sortDirection = 'asc'
    ): QueryBuilder {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p');

        if ($search) {
            $queryBuilder
                ->andWhere('LOWER(p.name) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($type) {
            $queryBuilder
                ->andWhere("JSON_CONTAINS(p.types, :type, '$[*].type.name') = 1")
                ->setParameter('type', json_encode($type));
        }

        if ($sortBy === 'height') {
            $queryBuilder->orderBy('p.height', $sortDirection);
        } else {
            $queryBuilder->orderBy('p.name', $sortDirection);
        }

        return $queryBuilder;
    }

    public function getFilteredPaginator(
        QueryBuilder $queryBuilder,
        int $page,
        int $itemsPerPage
    ): Paginator {
        $queryBuilder
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        return new Paginator($queryBuilder);
    }

    
}   