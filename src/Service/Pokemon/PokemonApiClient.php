<?php

namespace App\Service\Pokemon;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[Autoconfigure(tags: ['app.pokemon_api_client'])]
class PokemonApiClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {}

    public function fetchPokemon(int $pokemonId): array
    {
        $response = $this->httpClient->request('GET', sprintf('/pokemon/%d', $pokemonId));

        dd($response);
        
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(sprintf('Impossible de récupérer les données du Pokémon #%d', $pokemonId));
        }

        return $response->toArray();
    }
}