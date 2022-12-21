<?php declare(strict_types=1);

namespace App\Command\Check;

use App\Check\Redis as RedisCheck;
use Predis\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'stack-check:redis', description: 'Check if Redis is functioning')]
class Redis extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $redisCheck = new RedisCheck();
        if (false === $redisCheck->ping()) {
            $output->writeln('<error>Could not connect to Redis</error>');
            return Command::FAILURE;
        }

        $table = new Table($output);
        $table->setHeaders(['Check', 'Outcome']);
        $table->addRow(['Redis database connection', 'Yes']);
        $table->addRow(['Redis server version', $redisCheck->version()]);


        $table->render();

        return Command::SUCCESS;
    }
}