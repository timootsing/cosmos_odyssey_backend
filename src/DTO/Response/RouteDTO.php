<?php

namespace App\DTO\Response;

use App\Entity\Planet;
use DateTimeImmutable;

class RouteDTO
{
    private string $id;

    private PlanetDTO $origin;
    private array $flightsInRoute;
    private PlanetDTO $destination;
    private int $distance;
    private string $travelTime;
    private string $endAt;
    private float $price;
    private string $startAt;

    public function __construct(
        int $id,
        PlanetDTO $origin,
        PlanetDTO $destination,
        int $distance,
        float $price,
        string $travelTime,
        string $startAt,
        string $endAt,
        array $flightsInRoute,
    )
    {
        $this->id = $id;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->distance = $distance;
        $this->price = $price;
        $this->travelTime = $travelTime;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->flightsInRoute = $flightsInRoute;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrigin(): PlanetDTO
    {
        return $this->origin;
    }

    public function getFlightsInRoute(): array
    {
        return $this->flightsInRoute;
    }

    public function getStartAt(): string
    {
        return $this->startAt;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDestination(): PlanetDTO
    {
        return $this->destination;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getTravelTime(): string
    {
        return $this->travelTime;
    }

    public function getEndAt(): string
    {
        return $this->endAt;
    }
}
