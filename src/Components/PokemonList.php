<?php

declare(strict_types=1);

namespace App\Components;

use App\Repository\PokemonRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('pokemon_list')]
class PokemonList
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveProp(writable: true)]
    public ?string $type = null;

    #[LiveProp(writable: true)]
    public string $sortBy = 'name';

    #[LiveProp(writable: true)]
    public string $sortDirection = 'asc';

    public function __construct(
        private readonly PokemonRepository $pokemonRepository
    ) {
    }

    public function getPokemons(): array
    {
        $queryBuilder = $this->pokemonRepository->createQueryBuilder('p');

        // Apply search filter
        if ($this->search) {
            $queryBuilder
                ->andWhere('LOWER(p.name) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $this->search . '%');
        }

        // Apply type filter
        if ($this->type) {
            $queryBuilder
                ->andWhere("jsonb_exists(p.types, :type)")
                ->setParameter('type', json_encode($this->type));
        }

        // Apply sorting
        if ($this->sortBy === 'height') {
            $queryBuilder->orderBy('p.height', $this->sortDirection);
        } else {
            $queryBuilder->orderBy('p.name', $this->sortDirection);
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
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