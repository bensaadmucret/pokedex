<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function save(Pokemon $pokemon, bool $flush = false): void
    {
        $this->getEntityManager()->persist($pokemon);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pokemon $pokemon, bool $flush = false): void
    {
        $this->getEntityManager()->remove($pokemon);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Pokemon[]
     */
    public function findAllOptimized(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByNamePartial(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('LOWER(p.name) LIKE LOWER(:name)')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}