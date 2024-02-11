<?php

namespace App\DTO\Response;

use App\Entity\Route;

class BookingDTO
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private Route $route;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        Route $route,
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->route = $route;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

}
