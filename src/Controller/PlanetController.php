<?php

namespace App\Controller;

use App\DTO\Response\PlanetDTO;
use App\Map\PlanetResponseMap;
use App\Repository\PlanetRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route(path: "/api/planet", name: "api_")]
class PlanetController extends AbstractFOSRestController
{
    public function __construct(
        private readonly PlanetRepository $planetRepository,
    )
    {
    }

    #[Get(path: '/')]
    public function getPlanets(): JsonResponse
    {
        $planets = $this->planetRepository->findAll();
        $mappedPlanets = array_map(fn($planet): PlanetDTO => PlanetResponseMap::mapEntityToDTO($planet), $planets);
        return $this->json($mappedPlanets);
    }

}