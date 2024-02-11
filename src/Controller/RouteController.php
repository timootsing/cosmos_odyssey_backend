<?php

namespace App\Controller;

use App\Paginator\RoutePaginator;
use App\Repository\RouteRepository;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

#[Route(path: "/api/route", name: "api_")]
class RouteController extends AbstractController
{
    protected const PAGE_SIZE = 20;

    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly RoutePaginator $routePaginator,
    )
    {
    }

    #[Get(path: '/')]
    public function getRoutes(
        #[MapQueryParameter] int $originId,
        #[MapQueryParameter] int $destinationId,
        #[MapQueryParameter] ?int $providerId = null,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter] string $sortBy = 'price',
        #[MapQueryParameter] string $sortOrder = 'ASC',
    ): JsonResponse {
        $routes = $this->routeRepository->getQuery(
            $originId,
            $destinationId,
            $providerId,
            $sortBy,
            $sortOrder
        );

        $response = $this->routePaginator->paginate($routes, $page);

        return $this->json($response);
    }
}