<?php declare(strict_types=1);

namespace App\Controller;

use App\Check\Redis as RedisCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Redis extends AbstractController
{
    #[Route('/api/redis', name: 'redis')]
    public function index(): JsonResponse
    {
        $redisCheck = new RedisCheck();


        return $this->json([
            'ping' => $redisCheck->ping(),
            'version' => $redisCheck->version(),
        ]);
    }
}