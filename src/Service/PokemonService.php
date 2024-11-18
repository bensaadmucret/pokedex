<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PokemonDTO;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class PokemonService
{
    private const API_BASE_URL = 'https://pokeapi.co/api/v2';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly PokemonRepository $pokemonRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly LoggerInterface $logger
    ) {
    }

    public function fetchAndSavePokemon(int $id): Pokemon
    {
        return $this->cache->get(
            "pokemon_$id",
            function () use ($id) {
                $response = $this->httpClient->request('GET', self::API_BASE_URL . "/pokemon/$id");
                $data = $response->toArray();

                $dto = PokemonDTO::createFromArray($data);
                
                $pokemon = $this->pokemonRepository->find($id) ?? new Pokemon($id);
                $this->updatePokemonFromDTO($pokemon, $dto);
                
                $this->pokemonRepository->save($pokemon, true);
                return $pokemon;
            }
        );
    }

    private function updatePokemonFromDTO(Pokemon $pokemon, PokemonDTO $dto): void
    {
        $pokemon
            ->setName($dto->name)
            ->setBaseExperience($dto->baseExperience)
            ->setHeight($dto->height)
            ->setIsDefault($dto->isDefault)
            ->setPokemonOrder($dto->pokemonOrder)
            ->setWeight($dto->weight)
            ->setAbilities($dto->abilities)
            ->setForms($dto->forms)
            ->setGameIndices($dto->gameIndices)
            ->setHeldItems($dto->heldItems)
            ->setLocationAreaEncounters($dto->locationAreaEncounters)
            ->setMoves($dto->moves)
            ->setPastTypes($dto->pastTypes)
            ->setStats($dto->stats)
            ->setTypes($dto->types)
            ->updateTimestamp();
    }

    /**
     * @return Pokemon[]
     */
    public function getAllPokemon(): array
    {
        return $this->cache->get('all_pokemon', function () {
            return $this->pokemonRepository->findAllOptimized();
        });
    }

    public function searchPokemon(string $name): array
    {
        return $this->cache->get('search_' . md5($name), function () use ($name) {
            return $this->pokemonRepository->findByNamePartial($name);
        });
    }

    public function invalidateCache(int $id): void
    {
        $this->cache->delete("pokemon_$id");
        $this->cache->delete('all_pokemon');
    }
}