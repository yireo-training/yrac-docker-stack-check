<?php declare(strict_types=1);

namespace App\Command\Check;

use App\Check\ElasticSearch as ElasticSearchCheck;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'stack-check:elasticsearch', description: 'Check if ElasticSearch is functioning')]
class ElasticSearch extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $elasticSearchCheck = new ElasticSearchCheck();
        if (false === $elasticSearchCheck->ping()) {
            $output->writeln('<error>Could not connect to ElasticSearch</error>');
            return Command::FAILURE;
        }

        $table = new Table($output);
        $table->setHeaders(['Check', 'Outcome']);
        $table->addRow(['ElasticSearch database connection', 'Yes']);
        $table->addRow(['ElasticSearch version', $elasticSearchCheck->version()]);
        $table->render();

        return Command::SUCCESS;
    }
}