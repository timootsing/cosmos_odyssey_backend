<?php

namespace App\Controller;

use App\Paginator\RoutePaginator;
use App\Repository\PriceListRepository;
use App\Repository\RouteRepository;
use Doctrine\ORM\NonUniqueResultException;
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
        private readonly PriceListRepository $priceListRepository,
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
        try {
            $priceList = $this->priceListRepository->findLatestPriceList();
            if ($priceList === null) {
                return $this->json([]);
            }
            $routes = $this->routeRepository->getQuery(
                $originId,
                $destinationId,
                $providerId,
                $sortBy,
                $sortOrder,
                $priceList,
            );

            $response = $this->routePaginator->paginate($routes, $page);
            return $this->json($response);
        } catch (NonUniqueResultException $e) {
            return $this->json([]);
        }
    }
}