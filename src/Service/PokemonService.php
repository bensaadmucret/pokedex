<?php
namespace App\Service;

use App\DTO\PokemonDTO;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[Autowire]
class PokemonService
{
    private $httpClient;
    private $pokemonRepository;

    public function __construct(
        #[Autowire('pokeapi.client')] HttpClientInterface $httpClient,
        PokemonRepository $pokemonRepository
    ) {
        $this->httpClient = $httpClient;
        $this->pokemonRepository = $pokemonRepository;
    }

    public function fetchAndUpdatePokemons(int $count = 100): void
    {
        $randomIds = $this->getRandomPokemonIds($count);

        foreach ($randomIds as $id) {
            try {
                $pokemon = $this->fetchPokemonData($id);
                $this->updateOrCreatePokemon($pokemon);
            } catch (\Exception $e) {
                //$this->logger->error($e->getMessage());
            }
        }
    }

    private function getRandomPokemonIds(int $count): array
    {
        $maxId = 898; // Current number of Pokemon in PokeAPI
        return array_rand(range(1, $maxId), $count);
    }

    private function fetchPokemonData(int $id): PokemonDTO
    {
        $response = $this->httpClient->request('GET', sprintf('/pokemon/%d', $id));
        $data = $response->toArray();

        $pokemonDto = new PokemonDTO();
        $pokemonDto->name = $data['name'];
        $pokemonDto->image = $data['sprites']['front_default'];
        $pokemonDto->height = $data['height'];
        $pokemonDto->weight = $data['weight'];
        $pokemonDto->types = array_column($data['types'], 'type', 'name');

        return $pokemonDto;
    }

    private function updateOrCreatePokemon(PokemonDTO $pokemonDto): void
    {
        $pokemon = $this->pokemonRepository->findOneBy(['name' => $pokemonDto->name]);

        if ($pokemon) {
            $pokemon->updateFromDTO($pokemonDto);
        } else {
            $pokemon = new Pokemon();
            $pokemon->updateFromDTO($pokemonDto);
            $this->pokemonRepository->save($pokemon);
        }
    }

}