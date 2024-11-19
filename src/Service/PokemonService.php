<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PokemonDTO;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class PokemonService
{

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly PokemonRepository $pokemonRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly LoggerInterface $logger,
        private readonly string $apiBaseUrl,
    ) {
    }

    public function fetchAndSavePokemon(int $id): ?Pokemon
    {
        try {
            $response = $this->httpClient->request('GET', $this->apiBaseUrl . "/pokemon/$id");

            $data = $response->toArray();

            $dto = PokemonDTO::createFromArray($data);

            $pokemon = $this->pokemonRepository->find($id) ?? new Pokemon($id);
            $this->updatePokemonFromDTO($pokemon, $dto);

            $this->pokemonRepository->save($pokemon, true);

            return $pokemon;
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            $this->logger->error(sprintf(
                'Erreur lors de la récupération du Pokémon #%d : %s',
                $id,
                $e->getMessage()
            ));

            throw new \RuntimeException(sprintf(
                'Impossible de récupérer les informations du Pokémon #%d. Veuillez réessayer plus tard.',
                $id
            ));
        }
    }

    public function generateRandomPokemonIds(int $count = 100, int $minId = 1, int $maxId = 898): array
    {
        $ids = [];
        while (count($ids) < $count) {
            $id = random_int($minId, $maxId);
            if (!in_array($id, $ids)) {
                $ids[] = $id;
            }
        }
        return $ids;
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
            ->setSprites($dto->sprites)
            ->updateTimestamp();
    }


}