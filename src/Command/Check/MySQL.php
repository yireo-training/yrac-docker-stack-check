<?php declare(strict_types=1);

namespace App\Command\Check;

use App\Kernel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

#[AsCommand(name: 'stack-check:mysql', description: 'Check if MySQL is functioning')]
class MySQL extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rs = mysqli_connect($_ENV['MYSQL_HOST'], 'root', $_ENV['MYSQL_ROOT_PASSWORD'], $_ENV['MYSQL_DATABASE']);
        if (false === $rs) {
            $output->writeln('<error>Could not connect to MySQL</error>');
            return Command::FAILURE;
        }

        $output->writeln('MySQL works');
        return Command::SUCCESS;
    }
}