<?php declare(strict_types=1);

namespace App\Check;

use App\Kernel;
use GuzzleHttp\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

interface CheckInterface
{
    public function ping(): bool;

    public function version(): string;
}