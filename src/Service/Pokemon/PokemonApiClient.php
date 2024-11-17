<?php

namespace App\Service\Pokemon;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['app.pokemon_api_client'])]
class PokemonApiClient
{
    public function __construct(
        private readonly HttpClientInterface $pokeApiClient
    ) {}

    public function fetchPokemon(int $pokemonId): array
    {
        $response = $this->pokeApiClient->request('GET', sprintf('/api/v2/pokemon/%d', $pokemonId));

        dd($response->toArray());
        
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException(sprintf('Impossible de récupérer les données du Pokémon #%d', $pokemonId));
        }

        return $response->toArray();
    }
}