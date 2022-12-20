<?php declare(strict_types=1);

namespace App\Config;

use App\Kernel;

class DockerCompose
{
    private Kernel $kernel;

    public function __construct(
        Kernel $kernel
    ) {
        $this->kernel = $kernel;
    }

    public function getData(): array
    {
        $dockerComposeFile = $this->kernel->getProjectDir() . '/docker-compose.yml';
        return yaml_parse_file($dockerComposeFile);
    }
}
