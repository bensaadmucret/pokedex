<?php

declare(strict_types=1);

namespace App\Components;

use App\Repository\PokemonRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[AsLiveComponent('pokemon_list')]
class PokemonListComponent
{
    use DefaultActionTrait;

    private const ITEMS_PER_PAGE = 12;

    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveProp(writable: true)]
    public ?string $type = null;

    #[LiveProp(writable: true)]
    public string $sortBy = 'name';

    #[LiveProp(writable: true)]
    public string $sortDirection = 'asc';

    #[LiveProp(writable: true)]
    public int $page = 1;

    #[LiveAction]
    public function updatePage(int $page): void
    {
        $this->page = $page;
    }

    public function __construct(
        private readonly PokemonRepository $pokemonRepository
    ) {
    }

    public function getPokemons(): Paginator
    {
        $queryBuilder = $this->pokemonRepository->createQueryBuilder('p');

        if ($this->search) {
            $queryBuilder
                ->andWhere('LOWER(p.name) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $this->search . '%');
        }

        if ($this->type) {
            $queryBuilder
                ->andWhere("JSON_CONTAINS(p.types, :type, '$[*].type.name') = 1")
                ->setParameter('type', json_encode($this->type));
        }

        if ($this->sortBy === 'height') {
            $queryBuilder->orderBy('p.height', $this->sortDirection);
        } else {
            $queryBuilder->orderBy('p.name', $this->sortDirection);
        }

        $queryBuilder
            ->setFirstResult(($this->page - 1) * self::ITEMS_PER_PAGE)
            ->setMaxResults(self::ITEMS_PER_PAGE);

        return new Paginator($queryBuilder);
    }

    public function getPaginationData(): array
    {
        $paginator = $this->getPokemons();
        $totalItems = count($paginator);
        $lastPage = ceil($totalItems / self::ITEMS_PER_PAGE);

        $neighbors = 2;
        $start = max(1, min($this->page - $neighbors, $lastPage - (2 * $neighbors)));
        $end = min($lastPage, max($this->page + $neighbors, (2 * $neighbors) + 1));

        return [
            'currentPage' => $this->page,
            'lastPage' => $lastPage,
            'start' => $start,
            'end' => $end,
            'totalItems' => $totalItems,
        ];
    }

    public function getPokemonTypes(): array
    {
        return [
            'Normal', 'Fire', 'Water', 'Electric', 'Grass', 'Ice', 'Fighting', 'Poison', 
            'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 
            'Steel', 'Fairy'
        ];
    }

    
}