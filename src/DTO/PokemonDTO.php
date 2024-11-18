<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

readonly class PokemonDTO
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public int $id,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(min: 1, max: 255)]
        public string $name,

        #[Assert\NotNull]
        #[Assert\Type('integer')]
        #[Assert\PositiveOrZero]
        #[SerializedName('base_experience')]
        public int $baseExperience,

        #[Assert\NotNull]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public int $height,

        #[Assert\NotNull]
        #[Assert\Type('boolean')]
        #[SerializedName('is_default')]
        public bool $isDefault,

        #[Assert\NotNull]
        #[Assert\Type('integer')]
        #[Assert\PositiveOrZero]
        public int $pokemonOrder,

        #[Assert\NotNull]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public int $weight,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        public array $abilities,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        public array $forms,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        #[SerializedName('game_indices')]
        public array $gameIndices,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        #[SerializedName('held_items')]
        public array $heldItems,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Url]
        #[SerializedName('location_area_encounters')]
        public string $locationAreaEncounters,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        public array $moves,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        #[SerializedName('past_types')]
        public array $pastTypes,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        public array $stats,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        public array $types,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Valid]
        #[SerializedName('sprites')]
        public array $sprites,
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            baseExperience: $data['base_experience'],
            height: $data['height'],
            isDefault: $data['is_default'],
            pokemonOrder: $data['order'],
            weight: $data['weight'],
            abilities: $data['abilities'],
            forms: $data['forms'],
            gameIndices: $data['game_indices'],
            heldItems: $data['held_items'],
            locationAreaEncounters: $data['location_area_encounters'],
            moves: $data['moves'],
            pastTypes: $data['past_types'],
            stats: $data['stats'],
            types: $data['types'],
            sprites: $data['sprites'] ?? []
        );
    }
}