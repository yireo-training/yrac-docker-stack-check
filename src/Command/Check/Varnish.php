<?php declare(strict_types=1);

namespace App\Command\Check;

use App\Check\Varnish as VarnishCheck;
use App\Kernel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

#[AsCommand(name: 'stack-check:varnish', description: 'Check if Varnish is functioning')]
class Varnish extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $varnish = new VarnishCheck();
        if (false === $varnish->ping()) {
            $output->writeln('<error>Could not connect to Varnish</error>');
            return Command::FAILURE;
        }

        $table = new Table($output);
        $table->setHeaders(['Check', 'Outcome']);
        $table->addRow(['Varnish connection', 'Yes']);
        $table->addRow(['Backend server', $varnish->getBackendServer()]);
        $table->addRow(['Varnish version', $varnish->version()]);
        $table->render();

        return Command::SUCCESS;
    }
}