<?php declare(strict_types=1);

namespace App\Controller;

use App\Check\MySQL as MySQLCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MySQL extends AbstractController
{
    #[Route('/api/mysql', name: 'mysql')]
    public function index(): JsonResponse
    {
        $mysqlCheck = new MySQLCheck();


        return $this->json([
            'ping' => $mysqlCheck->ping(),
            'version' => $mysqlCheck->version(),
            'client_version' => $mysqlCheck->getClientVersion(),
        ]);
    }
}