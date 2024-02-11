<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class RouteDTO
{
    public function __construct(
        #[NotBlank(message: 'Select origin')]
        public readonly int $originId,

        #[NotBlank(message: 'Select destination')]
        public readonly int $destinationId,

        public readonly ?int $providerId = null,

        public readonly int $page = 1,

        public readonly string $sortBy = 'price',

        public readonly string $sortOrder = 'asc',
    )
    {
    }

    public function getOriginId(): int
    {
        return $this->originId;
    }

    public function getDestinationId(): int
    {
        return $this->destinationId;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }

    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

}
