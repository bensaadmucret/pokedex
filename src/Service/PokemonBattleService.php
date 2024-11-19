<?php

namespace App\Service;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['app.pokemon_battle_service'])]
final readonly class PokemonBattleService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function simulateBattle(int $pokemon1Id, int $pokemon2Id): array
    {
        $pokemon1 = $this->fetchPokemon($pokemon1Id);
        $pokemon2 = $this->fetchPokemon($pokemon2Id);

        if (!$pokemon1 || !$pokemon2) {
            throw new \RuntimeException('Aucun Pokémon trouvé.');
        }

        $score1 = $this->calculateScore($pokemon1);
        $score2 = $this->calculateScore($pokemon2);

        $winner = $score1 > $score2 ? $pokemon1 : $pokemon2;

        return [
            'winner' => [
                'id' => $winner->getId(),
                'name' => $winner->getName()
            ],
            'details' => [
                'pokemon1' => $pokemon1->toArray(),  
                'pokemon2' => $pokemon2->toArray(),
                'score1' => $score1,
                'score2' => $score2
            ]
        ];
    }

    private function fetchPokemon(int $pokemonId): ?Pokemon
    {
        return $this->entityManager->getRepository(Pokemon::class)->find($pokemonId);
    }

    private function calculateScore(Pokemon $pokemon): int
    {
        // somme des statistiques de base (attaque, défense, expérience)
        return $pokemon->getHp() + $pokemon->getAttack() + $pokemon->getDefense();
    }
}