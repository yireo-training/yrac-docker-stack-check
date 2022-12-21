<?php declare(strict_types=1);

namespace App\Controller;

use App\Check\ElasticSearch as ElasticSearchCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ElasticSearch extends AbstractController
{
    #[Route('/api/elasticsearch', name: 'elasticsearch')]
    public function index(): JsonResponse
    {
        $elasticsearchCheck = new ElasticSearchCheck();

        return $this->json([
            'ping' => $elasticsearchCheck->ping(),
            'version' => $elasticsearchCheck->version(),
        ]);
    }
}