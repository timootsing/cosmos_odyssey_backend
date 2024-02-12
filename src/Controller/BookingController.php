<?php

namespace App\Controller;

use App\DTO\Request\BookingDTO;
use App\Factory\BookingBuilder;
use App\Map\BookingResponseMap;
use App\Repository\BookingRepository;
use App\Repository\PriceListRepository;
use App\Repository\RouteRepository;
use Doctrine\ORM\NonUniqueResultException;
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
        private readonly BookingRepository $bookingRepository,
        private readonly PriceListRepository $priceListRepository,
        private readonly RouteRepository $routeRepository,
        private readonly BookingBuilder $bookingBuilder,
    )
    {
    }

    #[Get(path: '/')]
    public function getBookings(): JsonResponse
    {
        $bookings = $this->bookingRepository->findAll();
        $mappedBookings = array_map(fn($booking): \App\DTO\Response\BookingDTO => BookingResponseMap::mapEntityToDTO($booking), $bookings);
        return $this->json($mappedBookings);
    }

    #[Post(path: '/')]
    public function createBooking(
        #[MapRequestPayload] BookingDTO $bookingDTO,
    ): JsonResponse
    {
        try {
            $latestPriceList = $this->priceListRepository->findLatestPriceList();
            $route = $this->routeRepository->find($bookingDTO->getRouteId());
            if ($latestPriceList === $route->getPriceList()) {
                $booking = $this->bookingBuilder->createBooking($bookingDTO);
                return $this->json(BookingResponseMap::mapEntityToDTO($booking));
            }

            return $this->json(['error' => 'The price list has expired. Please reload the page and try again.']);
        } catch (NonUniqueResultException $e) {
            return $this->json(['error' => 'Something went wrong']);
        }
    }

}