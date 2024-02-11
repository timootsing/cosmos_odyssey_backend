<?php

namespace App\DTO\Response;

class PaginationTableDTO
{
    private array $items;

    private PaginationDTO $pagination;

    public function __construct(
        array $items,
        PaginationDTO $pagination,
    )
    {
        $this->items = $items;
        $this->pagination = $pagination;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return PaginationDTO
     */
    public function getPagination(): PaginationDTO
    {
        return $this->pagination;
    }

}