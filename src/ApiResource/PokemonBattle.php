<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\PokemonBattleController;
use App\DTO\PokemonBattleInput;
use ApiPlatform\OpenApi\Model;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/pokemon-battles',
            input: PokemonBattleInput::class,
            controller: PokemonBattleController::class,
            openapi: new Model\Operation(
                summary: 'Simule un combat entre deux Pokémon',
                description: 'Cette opération permet de simuler un combat entre deux Pokémon en utilisant leurs IDs.',
                requestBody: new Model\RequestBody(
                    description: 'Les IDs des deux Pokémon à combattre.',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'pokemon1' => [
                                        'type' => 'integer',
                                        'description' => 'L\'ID du premier Pokémon.'
                                    ],
                                    'pokemon2' => [
                                        'type' => 'integer',
                                        'description' => 'L\'ID du deuxième Pokémon.'
                                    ]
                                ],
                                'required' => ['pokemon1', 'pokemon2']
                            ]
                        ]
                    ])
                )
            )
        )
    ],
)]
class PokemonBattle
{
}