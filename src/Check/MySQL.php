<?php declare(strict_types=1);

namespace App\Check;

class MySQL implements CheckInterface
{
    public function ping(): bool
    {
        $rs = mysqli_connect($_ENV['MYSQL_HOST'], 'root', $_ENV['MYSQL_ROOT_PASSWORD'], $_ENV['MYSQL_DATABASE']);
        return (bool)$rs;
    }

    public function version(): string
    {
        $rs = $this->getConnection();
        return (string)mysqli_get_server_version($rs);
    }

    public function getClientVersion(): string
    {
        return (string)mysqli_get_client_version();
    }

    private function getConnection()
    {
        return mysqli_connect($_ENV['MYSQL_HOST'], 'root', $_ENV['MYSQL_ROOT_PASSWORD'], $_ENV['MYSQL_DATABASE']);
    }
}