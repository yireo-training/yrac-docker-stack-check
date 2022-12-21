<?php declare(strict_types=1);

namespace App\Check;

use Predis\Client;

class Redis implements CheckInterface
{
    public function ping(): bool
    {
        $redisClient = $this->getClient();
        $info = $redisClient->info();
        return $info ? true : false;
    }

    public function version(): string
    {
        $redisClient = $this->getClient();
        $info = $redisClient->info();
        return $info['Server']['redis_version'];
    }

    private function getClient(): Client
    {
        return new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
    }
}