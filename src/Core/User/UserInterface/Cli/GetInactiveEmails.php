<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\Query\GetInactiveUserEmails\GetInactiveUserEmailsQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:get-inactive-emails',
    description: 'Wyświetla e-maile nieaktywnych użytkowników'
)]
class GetInactiveEmails extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emails = $this->bus->dispatch(new GetInactiveUserEmailsQuery());

        foreach ($emails as $email) {
            $output->writeln($email);
        }

        return Command::SUCCESS;
    }
}