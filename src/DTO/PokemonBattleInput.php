<?php 

declare(strict_types=1);


namespace App\DTO;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Validator\Constraints as Assert;

class PokemonBattleInput
{
    #[Assert\NotBlank(message: "Le champ pokemon1 ne peut pas être vide.")]
    #[Assert\Positive(message: "Le champ pokemon1 doit être un nombre positif.")]
    #[ApiProperty(description: "L'ID du premier Pokémon.")]
    public ?int $pokemon1 = null;

    #[Assert\NotBlank(message: "Le champ pokemon2 ne peut pas être vide.")]
    #[Assert\Positive(message: "Le champ pokemon2 doit être un nombre positif.")]
    #[ApiProperty(description: "L'ID du deuxième Pokémon.")]
    public ?int $pokemon2 = null;


    public function __construct(int $pokemon1, int $pokemon2)
    {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
    }
}