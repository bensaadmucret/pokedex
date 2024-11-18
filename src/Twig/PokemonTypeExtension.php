<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PokemonTypeExtension extends AbstractExtension
{
    private const TYPE_CLASSES = [
        'normal' => 'bg-gray-200 text-gray-800',
        'fire' => 'bg-red-200 text-red-800',
        'water' => 'bg-blue-200 text-blue-800',
        'electric' => 'bg-yellow-200 text-yellow-800',
        'grass' => 'bg-green-200 text-green-800',
        'ice' => 'bg-cyan-200 text-cyan-800',
        'fighting' => 'bg-red-300 text-red-900',
        'poison' => 'bg-purple-200 text-purple-800',
        'ground' => 'bg-yellow-300 text-yellow-900',
        'flying' => 'bg-indigo-200 text-indigo-800',
        'psychic' => 'bg-pink-200 text-pink-800',
        'bug' => 'bg-lime-200 text-lime-800',
        'rock' => 'bg-yellow-400 text-yellow-900',
        'ghost' => 'bg-purple-300 text-purple-900',
        'dragon' => 'bg-violet-200 text-violet-800',
        'dark' => 'bg-gray-700 text-gray-100',
        'steel' => 'bg-gray-400 text-gray-900',
        'fairy' => 'bg-pink-300 text-pink-900',
    ];

    public function getFilters(): array
    {
        return [
            new TwigFilter('pokemon_type_class', [$this, 'getPokemonTypeClass']),
        ];
    }

    public function getPokemonTypeClass(string $type): string
    {
        return self::TYPE_CLASSES[strtolower($type)] ?? 'bg-gray-200 text-gray-800';
    }
}