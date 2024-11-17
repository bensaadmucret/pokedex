<?php

namespace App\Service\Pokemon;

use App\Entity\Pokemon;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;


#[Autoconfigure(tags: ['app.pokemon_data_transformer'])]
class PokemonDataTransformer
{
    public function transformToPokemon(array $pokemonData, ?Pokemon $existingPokemon = null): Pokemon
    {
        $pokemon = $existingPokemon ?? new Pokemon();
        
        return $pokemon
            ->setId($pokemonData['id'])
            ->setName($pokemonData['name'])
            ->setImage($pokemonData['sprites']['other']['official-artwork']['front_default'])
            ->setHeight($pokemonData['height'] / 10)
            ->setWeight($pokemonData['weight'] / 10)
            ->setTypes(array_map(fn($type) => $type['type']['name'], $pokemonData['types']));
    }

    private function getStatValue(array $stats, string $statName): int
    {
        foreach ($stats as $stat) {
            if ($stat['stat']['name'] === $statName) {
                return $stat['base_stat'];
            }
        }
        return 0;
    }
}