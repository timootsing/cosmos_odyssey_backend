<?php

namespace App\Map;

use App\DTO\Response\FlightDTO;
use App\DTO\Response\RouteDTO;
use App\Entity\Flight;
use App\Entity\Route;
use DateTimeImmutable;

class FlightResponseMap
{

    public static function mapEntityToDTO(Flight $flight): FlightDTO
    {
        return new FlightDTO(
            $flight->getId(),
            PlanetResponseMap::mapEntityToDTO($flight->getLeg()->getOrigin()),
            PlanetResponseMap::mapEntityToDTO($flight->getLeg()->getDestination()),
            $flight->getPrice(),
            ProviderResponseMap::mapEntityToDTO($flight->getProvider()),
            DateTimeImmutable::createFromInterface($flight->getStartAt())->format('d.m.Y H:i:s'),
            DateTimeImmutable::createFromInterface($flight->getEndAt())->format('d.m.Y H:i:s'),
        );
    }

}
