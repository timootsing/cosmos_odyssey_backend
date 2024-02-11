<?php

namespace App\Factory;

use App\Entity\Flight;
use App\Entity\Leg;
use App\Entity\Planet;
use App\Entity\PriceList;
use App\Entity\Provider;
use App\Repository\PlanetRepository;
use App\Repository\ProviderRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class PriceListBuilder
{
    public function __construct(
        private readonly PlanetRepository   $planetRepository,
        private readonly ProviderRepository  $providerRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function createPriceList(array $priceListData): PriceList
    {
        $priceList = (new PriceList())
            ->setValidUntil(new DateTimeImmutable($priceListData['validUntil']));

        $this->createLegs($priceListData['legs'], $priceList);

        $this->entityManager->persist($priceList);
        $this->entityManager->flush();

        return $priceList;
    }

    private function createLegs(array $legs, PriceList $priceList): void
    {
        foreach ($legs as $leg) {
            $routeInfo = $leg['routeInfo'];
            $distance = $routeInfo['distance'];

            $originPlanet = $this->getOrCreatePlanet($routeInfo['from']['name']);
            $destinationPlanet = $this->getOrCreatePlanet($routeInfo['to']['name']);

            $newLeg = (new Leg())
                ->setOrigin($originPlanet)
                ->setDestination($destinationPlanet)
                ->setDistance($distance);
            $priceList->addLeg($newLeg);

            $this->createFlights($leg['providers'], $newLeg);
        }
    }

    private function createFlights(array $flights, Leg $leg): void
    {
        foreach ($flights as $flight) {
            $provider = $this->getOrCreateProvider($flight['company']['name']);
            $leg->addFlight(
                (new Flight())
                    ->setProvider($provider)
                    ->setStartAt(new DateTimeImmutable($flight['flightStart']))
                    ->setEndAt(new DateTimeImmutable($flight['flightEnd']))
                    ->setPrice($flight['price'])
            );
        }
    }

    private function getOrCreateProvider(string $name): Provider
    {
        $provider = $this->providerRepository->findOneBy(['name' => $name]);
        if ($provider !== null) {
            return $provider;
        }

        $provider = (new Provider())
            ->setName($name);

        $this->providerRepository->save($provider, true);

        return $provider;
    }

    private function getOrCreatePlanet(string $name): Planet
    {
        $planet = $this->planetRepository->findOneBy(['name' => $name]);
        if ($planet !== null) {
            return $planet;
        }

        $planet = (new Planet())
            ->setName($name);

        $this->planetRepository->save($planet, true);

        return $planet;
    }
}