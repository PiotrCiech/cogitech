<?php

namespace App\Command;

use App\Service\PostImporterService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-posts',
    description: 'Pobiera posty z API i zapisuje je do bazy danych.',
)]
class ImportPostsCommand extends Command
{
    public function __construct(
        private readonly PostImporterService $importer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Importowanie postów z jsonplaceholder.typicode.com');

        $this->importer->import();

        $io->success("Import zakończony pomyślnie.");

        return Command::SUCCESS;
    }
}
