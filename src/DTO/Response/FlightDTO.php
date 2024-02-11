<?php

namespace App\DTO\Response;

use DateTimeImmutable;

class FlightDTO
{
    private int $id;
    private PlanetDTO $origin;
    private PlanetDTO $destination;
    private float $price;
    private ProviderDTO $provider;
    private string $startAt;
    private string $endAt;

    public function __construct(
        int $id,
        PlanetDTO $origin,
        PlanetDTO $destination,
        float $price,
        ProviderDTO $provider,
        string $startAt,
        string $endAt,
    )
    {
        $this->id = $id;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->price = $price;
        $this->provider = $provider;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrigin(): PlanetDTO
    {
        return $this->origin;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDestination(): PlanetDTO
    {
        return $this->destination;
    }

    public function getEndAt(): string
    {
        return $this->endAt;
    }

    public function getProvider(): ProviderDTO
    {
        return $this->provider;
    }

    public function getStartAt(): string
    {
        return $this->startAt;
    }
}
