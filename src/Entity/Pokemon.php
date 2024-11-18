<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ORM\Table(name: 'pokemon')]
#[ORM\Index(columns: ['name'], name: 'pokemon_name_idx')]
#[ORM\Cache(usage: 'READ_WRITE', region: 'pokemon_region')]
class Pokemon
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $baseExperience;

    #[ORM\Column(type: Types::INTEGER)]
    private int $height;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isDefault;

    #[ORM\Column(type: Types::INTEGER)]
    private int $order;

    #[ORM\Column(type: Types::INTEGER)]
    private int $weight;

    #[ORM\Column(type: Types::JSON)]
    private array $abilities = [];

    #[ORM\Column(type: Types::JSON)]
    private array $forms = [];

    #[ORM\Column(type: Types::JSON)]
    private array $gameIndices = [];

    #[ORM\Column(type: Types::JSON)]
    private array $heldItems = [];

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $locationAreaEncounters;

    #[ORM\Column(type: Types::JSON)]
    private array $moves = [];

    #[ORM\Column(type: Types::JSON)]
    private array $pastTypes = [];

    #[ORM\Column(type: Types::JSON)]
    private array $stats = [];

    #[ORM\Column(type: Types::JSON)]
    private array $types = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->updatedAt = new \DateTimeImmutable();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBaseExperience(): int
    {
        return $this->baseExperience;
    }

    public function setBaseExperience(int $baseExperience): self
    {
        $this->baseExperience = $baseExperience;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function setAbilities(array $abilities): self
    {
        $this->abilities = $abilities;
        return $this;
    }

    public function getForms(): array
    {
        return $this->forms;
    }

    public function setForms(array $forms): self
    {
        $this->forms = $forms;
        return $this;
    }

    public function getGameIndices(): array
    {
        return $this->gameIndices;
    }

    public function setGameIndices(array $gameIndices): self
    {
        $this->gameIndices = $gameIndices;
        return $this;
    }

    public function getHeldItems(): array
    {
        return $this->heldItems;
    }

    public function setHeldItems(array $heldItems): self
    {
        $this->heldItems = $heldItems;
        return $this;
    }

    public function getLocationAreaEncounters(): string
    {
        return $this->locationAreaEncounters;
    }

    public function setLocationAreaEncounters(string $locationAreaEncounters): self
    {
        $this->locationAreaEncounters = $locationAreaEncounters;
        return $this;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function setMoves(array $moves): self
    {
        $this->moves = $moves;
        return $this;
    }

    public function getPastTypes(): array
    {
        return $this->pastTypes;
    }

    public function setPastTypes(array $pastTypes): self
    {
        $this->pastTypes = $pastTypes;
        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): self
    {
        $this->stats = $stats;
        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): self
    {
        $this->types = $types;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateTimestamp(): self
    {
        $this->updatedAt = new \DateTimeImmutable();
        return $this;
    }
}