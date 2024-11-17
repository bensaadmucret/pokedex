<?php

namespace App\Entity;

use App\DTO\PokemonDTO;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: "App\Repository\PokemonRepository")]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private ?string $name = null;

    #[ORM\Column(type: "text", nullable: true)]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private ?string $image = null;

    #[ORM\Column(type: "json")]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private array $types = [];

    #[ORM\Column(type: "integer")]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private ?int $height = null;

    #[ORM\Column(type: "integer")]
    #[Groups(["pokemon:read", "pokemon:write"])]
    private ?int $weight = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
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

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}