<?php

namespace App\Map;

use App\DTO\Response\FlightDTO;
use App\DTO\Response\RouteDTO;
use App\Entity\Route;
use DateTimeImmutable;

class RouteResponseMap
{

    /**
     * @param Route $route
     * @return RouteDTO
     */
    public static function mapEntityToDTO(Route $route): RouteDTO
    {
        return new RouteDTO(
            $route->getId(),
            PlanetResponseMap::mapEntityToDTO($route->getOrigin()),
            PlanetResponseMap::mapEntityToDTO($route->getDestination()),
            $route->getDistance(),
            $route->getPrice(),
            self::travelTimeToString($route->getTravelTime()),
            DateTimeImmutable::createFromInterface($route->getStartAt())->format('d.m.Y H:i:s'),
            DateTimeImmutable::createFromInterface($route->getEndAt())->format('d.m.Y H:i:s'),
            self::mapFlightsInRoute($route->getFlightsInRoute())
        );
    }

    private static function travelTimeToString($seconds): string
    {
        $days = floor($seconds / (60 * 60 * 24));
        $hours = floor(($seconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($seconds % (60 * 60)) / 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = $days . ' days';
        }
        if ($hours > 0) {
            $parts[] = $hours . ' hours';
        }
        if ($minutes > 0) {
            $parts[] = $minutes . ' minutes';
        }

        return implode(', ', $parts);
    }

    private static function mapFlightsInRoute($flights): array
    {
        $flightsInRoute = [];
        foreach ($flights as $flight) {
            $flightsInRoute[] = FlightResponseMap::mapEntityToDTO($flight->getFlight());
        }
        return $flightsInRoute;
    }

}
