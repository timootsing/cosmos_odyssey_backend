<?php

namespace App\Map;

use App\DTO\Response\BookingDTO;
use App\Entity\Booking;

class BookingResponseMap
{
    /**
     * @param Booking $booking
     * @return BookingDTO
     */
    public static function mapEntityToDTO(Booking $booking): BookingDTO
    {
        return new BookingDTO(
            $booking->getId(),
            $booking->getFirstName(),
            $booking->getLastName(),
            RouteResponseMap::mapEntityToDTO($booking->getRoute()),
        );
    }

}
