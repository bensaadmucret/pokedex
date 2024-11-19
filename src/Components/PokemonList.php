<?php

namespace App\Components;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use App\Service\PokemonService;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('pokemon_list')]
class PokemonList
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public string $type = '';

    #[LiveProp(writable: true)]
    public string $sortBy = 'name';

    #[LiveProp(writable: true)]
    public string $sortDirection = 'asc';

    #[LiveProp]
    public int $limit = 151;

    public function __construct(
        private readonly PokemonService $pokemonService,
        private readonly PokemonRepository $pokemonRepository,
    ) {}
    
    /**
     * Retourne les types de Pokémon disponibles
     *
     * @return array    
     */
    public function getPokemonTypes(): array
    {
        return [
            'Normal', 'Fire', 'Water', 'Electric', 'Grass', 'Ice',
            'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic',
            'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel', 'Fairy'
        ];
    }


    /**
     * @return Pokemon[]
     */
    public function getPokemons(): array
    {
        $pokemons = $this->pokemonRepository->findAllOptimized();

        // Filtrage par nom
        if (!empty($this->query)) {
            $pokemons = array_filter($pokemons, function(Pokemon $pokemon) {
                return str_contains(
                    strtolower($pokemon->getName()), 
                    strtolower($this->query)
                );
            });
            if (empty($pokemons)) {
                $pokemons = [];
            }
        }

        // Filtrage par type
        if (!empty($this->type)) {
            $pokemons = array_filter($pokemons, function(Pokemon $pokemon) {
                foreach ($pokemon->getTypes() as $pokemonType) {
                    if (strtolower($pokemonType['type']['name']) === strtolower($this->type)) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Tri
        usort($pokemons, function(Pokemon $a, Pokemon $b) {
            $modifier = $this->sortDirection === 'asc' ? 1 : -1;
            
            return match($this->sortBy) {
                'name' => $modifier * strcmp($a->getName(), $b->getName()),
                'id' => $modifier * ($a->getId() - $b->getId()),
                'height' => $modifier * ($a->getHeight() - $b->getHeight()),
                'weight' => $modifier * ($a->getWeight() - $b->getWeight()),
                default => 0
            };
        });

        return array_values($pokemons);
    }

   
    /**
     * Inverse la direction de tri
     */
    public function toggleSort(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
}