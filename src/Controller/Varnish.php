<?php declare(strict_types=1);

namespace App\Controller;

use App\Check\Varnish as VarnishCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Varnish extends AbstractController
{
    #[Route('/api/varnish', name: 'varnish')]
    public function index(): JsonResponse
    {
        $varnishCheck = new VarnishCheck();


        return $this->json([
            'ping' => $varnishCheck->ping(),
            'version' => $varnishCheck->version(),
            'backend_server' => $varnishCheck->getBackendServer(),
        ]);
    }
}