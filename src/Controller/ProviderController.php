<?php

namespace App\Controller;

use App\DTO\Response\ProviderDTO;
use App\Map\ProviderResponseMap;
use App\Repository\ProviderRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route(path: "/api/provider", name: "api_")]
class ProviderController extends AbstractFOSRestController
{
    public function __construct(
        private readonly ProviderRepository $providerRepository,
    )
    {
    }

    #[Get(path: '/')]
    public function getProviders(): JsonResponse
    {
        $providers = $this->providerRepository->findAll();
        $mappedProviders = array_map(fn($provider): ProviderDTO => ProviderResponseMap::mapEntityToDTO($provider), $providers);
        return $this->json($mappedProviders);
    }

}