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

class ElasticSearch implements CheckInterface
{
    public function ping(): bool
    {
        $httpClient = new Client();
        $response = $httpClient->request('GET', 'http://es:9200');
        if (false === $response) {
            return false;
        }

        return true;
    }

    public function version(): string
    {
        $httpClient = new Client();
        $response = $httpClient->request('GET', 'http://es:9200');
        $data = json_decode((string)$response->getBody(), true);
        return $data['version']['number'];
    }
}