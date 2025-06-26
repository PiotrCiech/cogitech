<?php

namespace App\Command;

use App\Factory\AdminFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Tworzy nowego admina z emailem i hasłem.',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
            private EntityManagerInterface $em,
            private AdminFactory $adminFactory
        ) {
            parent::__construct();
        }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email admina')
            ->addArgument('password', InputArgument::REQUIRED, 'Hasło admina');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');

        $admin = $this->adminFactory->create($email, $plainPassword);

        $this->em->persist($admin);
        $this->em->flush();

        $io->success("Admin o emailu $email został utworzony.");

        return Command::SUCCESS;
    }
}
