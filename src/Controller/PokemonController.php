<?php

namespace App\Controller;

use App\Service\PokemonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pokemon', name: 'pokemon')]
class PokemonController extends AbstractController
{
    public function __construct(
        private readonly PokemonService $pokemonService
    ) {}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $this->pokemonService->fetchAndUpdatePokemons();
        return $this->render('pokemon/index.html.twig');
    }    
}