<?php


use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class PokemonDTO
{
    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\NotNull]
    public int $id;

    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\NotBlank]
    public string $name;

    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\Url]
    public string $image;

    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\All([
        new Assert\Type('string'),
        new Assert\NotBlank
    ])]
    public array $types;

    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\Positive]
    public int $height;

    #[Groups(['pokemon:read', 'pokemon:write'])]
    #[Assert\Positive]
    public int $weight;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $image = '',
        array $types = [],
        int $height = 0,
        int $weight = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->types = $types;
        $this->height = $height;
        $this->weight = $weight;
    }
}