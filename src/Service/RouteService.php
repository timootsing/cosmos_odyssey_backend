<?php

namespace App\Service;

use App\Entity\Flight;
use App\Entity\FlightsInRoute;
use App\Entity\Planet;
use App\Entity\PriceList;
use App\Entity\Route;
use App\Repository\LegRepository;
use App\Repository\PlanetRepository;
use App\Repository\RouteRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class RouteService
{
    public function __construct(
        private readonly PlanetRepository           $planetRepository,
        private readonly LegRepository              $legRepository,
        private readonly RouteRepository            $routeRepository,
        private readonly EntityManagerInterface     $entityManager,
    )
    {
    }

    public function createRoutesForPriceList(PriceList $priceList): void
    {
        $start = microtime(true);
        $validPaths = $this->generatePaths($priceList);
        foreach ($validPaths as $path) {
            $validRoutes = [];
            $this->findValidRoutesRecursive($path, $priceList, [], $validRoutes);

            foreach ($validRoutes as $validRoute) {
                $firstFlight = $validRoute[0];
                $lastFlight = end($validRoute);

                $this->createRoute(
                    $priceList,
                    $firstFlight->getLeg()->getOrigin(),
                    $lastFlight->getLeg()->getDestination(),
                    $firstFlight->getStartAt(),
                    $lastFlight->getEndAt(),
                    $validRoute,
                );
            }
        }

        $this->entityManager->flush();
        $timeElapsed = microtime(true) - $start;
        echo "$timeElapsed seconds to create routes";
    }

    private function generatePaths(PriceList $priceList): array
    {
        $planets = $this->planetRepository->findAll();
        $validPaths = [];
        foreach ($planets as $originPlanet) {
            foreach ($planets as $destinationPlanet) {
                if ($originPlanet->getId() !== $destinationPlanet->getId()) {
                    $this->generatePathsDFS($originPlanet, $destinationPlanet, $priceList, $validPaths);
                }
            }
        }

        return $validPaths;
    }

    private function generatePathsDFS(
        Planet $originPlanet,
        Planet $destinationPlanet,
        PriceList $priceList, array &$validPaths,
        array $visited = [],
        array $path = []
    ): void {
        $visited[] = $originPlanet;

        if ($originPlanet === $destinationPlanet) {
            $validPaths[] = $path;
            return;
        }

        $legs = $this->legRepository->findBy(['origin' => $originPlanet, 'priceList' => $priceList]);

        foreach ($legs as $leg) {
            $nextPlanet = $leg->getDestination();
            if (!in_array($nextPlanet, $visited, true)) {
                $path[] = $leg;
                $this->generatePathsDFS($nextPlanet, $destinationPlanet, $priceList, $validPaths, $visited, $path);
                array_pop($path);
            }
        }
    }

    private function findValidRoutesRecursive(array $path, PriceList $currentPriceList, array $selectedFlights, array &$validRoutes): void
    {
        // Base case: If we have reached the end of the path, add the selected flights to the valid routes array
        if (count($selectedFlights) === count($path)) {
            $validRoutes[] = $selectedFlights;
            return;
        }

        $legIndex = count($selectedFlights); // Index of the leg we are currently processing
        $leg = $path[$legIndex];

        $flights = $leg->getFlights();
        foreach ($flights as $flight) {
            // Departure time wise
            if ($this->isFlightValidForLeg($flight, $selectedFlights)) {
                $selectedFlights[] = $flight;
                $this->findValidRoutesRecursive($path, $currentPriceList, $selectedFlights, $validRoutes);
                // Remove the last selected flight for backtracking
                array_pop($selectedFlights);
            }
        }
    }

    private function isFlightValidForLeg(Flight $flight, array $selectedFlights): bool
    {
        if (empty($selectedFlights)) {
            return true;
        }

        $previousFlight = end($selectedFlights);

        $previousFlightArrivalTime = $previousFlight->getEndAt();
        $currentFlightDepartureTime = $flight->getStartAt();

        // Ensure that the departure time of the current flight is after the arrival time of the previous flight
        if ($currentFlightDepartureTime > $previousFlightArrivalTime) {
            return true;
        }

        return false;
    }

    private function createRoute(
        PriceList $currentPriceList,
        Planet $originPlanet,
        Planet $finalPlanet,
        DateTimeImmutable $startAt,
        DateTimeImmutable $endAt,
        array $flightsInRoute,
    ): void {
        $route = (new Route())
            ->setOrigin($originPlanet)
            ->setDestination($finalPlanet)
            ->setPriceList($currentPriceList)
            ->setPrice($this->calculateRouteTotalPrice($flightsInRoute))
            ->setDistance($this->calculateRouteTotalDistance($flightsInRoute))
            ->setStartAt($startAt)
            ->setEndAt($endAt)
            ->setTravelTime($this->calculateTravelTimeSeconds($startAt, $endAt));

        $this->entityManager->persist($route);
        $this->createFlights($flightsInRoute, $route);
    }

    private function createFlights(array $flightsInRoute, Route $route): void
    {

        foreach($flightsInRoute as $orderNumber => $flight) {
            $flightInRoute = (new FlightsInRoute())
                ->setFlight($flight)
                ->setRoute($route)
                ->setProvider($flight->getProvider())
                ->setOrderNumber($orderNumber);
            $this->entityManager->persist($flightInRoute);
        }
    }

    private function calculateRouteTotalPrice($flights): float
    {
        $price = 0.0;

        foreach ($flights as $flight) {
            $price += $flight->getPrice();
        }

        return $price;
    }

    private function calculateRouteTotalDistance($flights): int
    {
        $distance = 0;

        foreach ($flights as $flight) {
            $distance += $flight->getLeg()->getDistance();
        }

        return $distance;
    }

    private function calculateTravelTimeSeconds($startAt, $endAt): int
    {
        $interval = $startAt->diff($endAt);

        return $interval->s
            + $interval->i * 60
            + $interval->h * 3600
            + $interval->days * 86400;
    }

}