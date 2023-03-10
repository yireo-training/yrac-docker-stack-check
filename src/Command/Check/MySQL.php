<?php declare(strict_types=1);

namespace App\Command\Check;

use App\Check\MySQL as MySQLCheck;
use App\Kernel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

#[AsCommand(name: 'stack-check:mysql', description: 'Check if MySQL is functioning')]
class MySQL extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $mysqlCheck = new MySQLCheck();
        if (false === $mysqlCheck->ping()) {
            $output->writeln('<error>Could not connect to MySQL</error>');
            return Command::FAILURE;
        }

        $table = new Table($output);
        $table->setHeaders(['Check', 'Outcome']);
        $table->addRow(['Basic MySQL database connection', 'Yes']);
        $table->addRow(['MySQL client version', $mysqlCheck->getClientVersion()]);
        $table->addRow(['MySQL server version', $mysqlCheck->version()]);

        $table->render();

        return Command::SUCCESS;
    }
}