<?php

namespace App\Controller;

use App\DTO\Request\BookingDTO;
use App\DTO\Response\PlanetDTO;
use App\Map\PlanetResponseMap;
use App\Repository\PlanetRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route(path: "/api/booking", name: "api_")]
class BookingController extends AbstractFOSRestController
{
    public function __construct(
        private readonly PlanetRepository $planetRepository,
    )
    {
    }

    #[Get(path: '/')]
    public function getBookings(): JsonResponse
    {
        $planets = $this->planetRepository->findAll();
        $mappedPlanets = array_map(fn($planet): PlanetDTO => PlanetResponseMap::mapEntityToDTO($planet), $planets);
        return $this->json($mappedPlanets);
    }

    #[Post(path: '/')]
    public function createBooking(
        #[MapRequestPayload] BookingDTO $bookingDTO,
    ): JsonResponse
    {
        // TODO: builder? Reposse create?
        return $this->json($mappedPlanets);
    }

}