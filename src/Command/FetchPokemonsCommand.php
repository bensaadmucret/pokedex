<?php

namespace App\Command;

use App\Service\Pokemon\PokemonFetcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fetch-pokemons',
    description: 'Récupère 100 Pokémon aléatoires depuis l\'API PokeAPI'
)]
class FetchPokemonsCommand extends Command
{

    public function __construct(private PokemonFetcher $pokemonService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Récupération de 100 Pokémon aléatoires');

        try {
            $this->pokemonService->fetchRandomPokemons();
            $io->success('Les Pokémon ont été mis à jour avec succès !');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error(sprintf("Une erreur est survenue : %s", $e->getMessage()));
            return Command::FAILURE;
        }
    }
}