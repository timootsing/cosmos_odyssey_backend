<?php

namespace App\Factory;

use App\DTO\Request\BookingDTO;
use App\Entity\Booking;
use App\Repository\RouteRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingBuilder
{
    public function __construct(
        private readonly RouteRepository  $routeRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function createBooking(BookingDTO $bookingDTO): Booking
    {
        $route = $this->routeRepository->find($bookingDTO->getRouteId());

        $booking = (new Booking())
            ->setRoute($route)
            ->setFirstName($bookingDTO->getFirstName())
            ->setLastName($bookingDTO->getLastName());


        $this->entityManager->persist($booking);
        $this->entityManager->flush();

        return $booking;
    }

}
