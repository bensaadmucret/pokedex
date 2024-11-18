<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bridge\Twig\Attribute\Template;
class PokemonController extends AbstractController
{
    #[Route('/', name: 'pokemon_list')]
    #[Template('pokemon/index.html.twig')] 
    public function index(TranslatorInterface $translator): array
    {
        // Traductions des titres
        $title = $translator->trans('pokemon.title');
        $subtitle = $translator->trans('pokemon.subtitle');

        return [
            'title' => $title,
            'subtitle' => $subtitle,
        ];
    }
}