<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\PokemonService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sync-pokemon',
    description: 'Synchronisez les données Pokémon, depuis PokeAPI'
)]
class SyncPokemonCommand extends Command
{
    public function __construct(
        private readonly PokemonService $pokemonService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('from', null, InputOption::VALUE_REQUIRED, 'Starting Pokemon ID', 1)
            ->addOption('to', null, InputOption::VALUE_REQUIRED, 'Ending Pokemon ID', 151)
            ->addOption('batch-size', null, InputOption::VALUE_REQUIRED, 'Number of Pokemon to process in parallel', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $from = (int) $input->getOption('from');
        $to = (int) $input->getOption('to');
        $batchSize = (int) $input->getOption('batch-size');

        $io->progressStart($to - $from + 1);

        for ($i = $from; $i <= $to; $i += $batchSize) {
            $batch = range($i, min($i + $batchSize - 1, $to));
            
            foreach ($batch as $id) {
                try {
                    $this->pokemonService->fetchAndSavePokemon($id);
                    $io->progressAdvance();
                } catch (\Exception $e) {
                    $io->error("Error processing Pokemon #$id: " . $e->getMessage());
                }
            }
        
            usleep(1000000); 
        }

        $io->progressFinish();
        $io->success('Synchronisation Pokémon terminée avec succès !');

        return Command::SUCCESS;
    }
}