<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ORM\Table(name: 'pokemon')]
#[ORM\Index(columns: ['name'], name: 'pokemon_name_idx')]
#[ORM\Cache(usage: 'READ_WRITE', region: 'pokemon_region')]
#[ApiResource(
    shortName: 'Pokemon',
    description: 'Une ressource représentant un Pokemon dans notre application',
    operations: [
        new GetCollection(
            openapi: new Model\Operation(
                summary: 'Récupérer tous les Pokemons',
                description: 'Retourne la liste complète des Pokemons disponibles avec leur nom et niveau.',
                responses: [
                    '200' => [
                        'description' => 'Liste des Pokemons récupérée avec succès',
                    ],
                    '404' => [
                        'description' => 'Aucun Pokemon trouvé',
                    ],
                ]
            ),
            normalizationContext: ['groups' => ['pokemon:read']]
        ),
        new Get(
            openapi: new Model\Operation(
                summary: 'Récupérer un Pokemon spécifique',
                description: 'Retourne les détails d\'un Pokemon en fonction de son identifiant.',
                responses: [
                    '200' => [
                        'description' => 'Pokemon trouvé avec succès',
                    ],
                    '404' => [
                        'description' => 'Pokemon non trouvé',
                    ],
                ]
            ),
            normalizationContext: ['groups' => ['pokemon:read']]
        ),
    ],
    paginationEnabled: true
)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['pokemon:read'])]
    #[ApiProperty(
        identifier: true,
        description: 'L\'identifiant unique du Pokemon',
        openapiContext: [
            'type' => 'integer',
            'example' => 1
        ]
    )]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['pokemon:read'])]
    #[ApiProperty(
        description: 'Le nom du Pokemon',
        openapiContext: [
            'type' => 'string',
            'example' => 'Pikachu',
            'maxLength' => 255
        ]
    )]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $baseExperience;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['pokemon:read'])]
    private int $height;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isDefault;

    #[ORM\Column(type: Types::INTEGER)]
    private int $pokemonOrder; 

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['pokemon:read'])]
    private int $weight;

    #[ORM\Column(type: 'json', nullable: true, options: ["jsonb" => true])]
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
    #[Groups(['pokemon:read'])]
    #[ApiProperty(
        description: 'Le niveau actuel du Pokemon',
        openapiContext: [
            'type' => 'integer',
            'example' => 25,
            'minimum' => 1,
            'maximum' => 100
        ]
    )]
    private array $stats = [];

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['pokemon:read'])]
    private array $types = [];

    #[ORM\Column(type: Types::JSON)]
    private array $sprites = [];

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
    
    public function getPokemonOrder(): int
    {
        return $this->pokemonOrder;
    }

    public function setPokemonOrder(int $pokemonOrder): self
    {
        $this->pokemonOrder = $pokemonOrder;
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

    public function getSprites(): array
    {
        return $this->sprites;
    }

    public function setSprites(array $sprites): self
    {
        $this->sprites = $sprites;
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

    public function getAttack(): int
    {
        return $this->stats['attack'] ?? 0;
    }

    public function getDefense(): int
    {
        return $this->stats['defense'] ?? 0;
    }

    public function getHp(): int
    {
        return $this->stats['hp'] ?? 0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'height' => $this->height,
            'weight' => $this->weight,
            'stats' => $this->stats,
            'types' => $this->types,
      
        ];
    }
}