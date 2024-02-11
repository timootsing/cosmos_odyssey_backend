<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class BookingDTO
{
    public function __construct(
        #[NotBlank(message: 'First name is missing')]
        public string $firstName,

        #[NotBlank(message: 'Last name is missing')]
        public string $lastName,

        #[NotBlank]
        public int $routeId,
    )
    {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getRouteId(): int
    {
        return $this->routeId;
    }

}
