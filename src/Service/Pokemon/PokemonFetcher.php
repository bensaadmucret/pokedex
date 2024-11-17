<?php

namespace App\Service\Pokemon;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['app.pokemon_fetcher'])]
class PokemonFetcher
{
    private const TOTAL_POKEMONS = 1008;

    public function __construct(
        private readonly PokemonApiClient $apiClient,
        private readonly PokemonDataTransformer $transformer,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function fetchRandomPokemons(int $count = 100): void
    {
        $randomIds = $this->generateRandomPokemonIds($count);

        foreach ($randomIds as $pokemonId) {
            $pokemonData = $this->apiClient->fetchPokemon($pokemonId);
            $existingPokemon = $this->entityManager->getRepository(Pokemon::class)->findOneBy(['apiId' => $pokemonId]);
            
            $pokemon = $this->transformer->transformToPokemon($pokemonData, $existingPokemon);
            $this->entityManager->persist($pokemon);
        }

        $this->entityManager->flush();
    }

    private function generateRandomPokemonIds(int $count): array
    {
        $ids = range(1, self::TOTAL_POKEMONS);
        shuffle($ids);
        return array_slice($ids, 0, $count);
    }
}