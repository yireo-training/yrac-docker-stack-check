<?php declare(strict_types=1);

namespace App\Command\Check;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'stack-check:mysql', description: 'Check if MySQL is functioning')]
class MySQL extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rs = mysqli_connect('localhost', 'root', 'root', 'magento2');
        if (false === $rs) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}