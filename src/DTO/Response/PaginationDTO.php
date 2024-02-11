<?php

namespace App\DTO\Response;

class PaginationDTO
{
    private int $totalPages;

    private int $currentPage;

    /**
     * @param int $totalPages
     * @param int $currentPage
     */
    public function __construct(
        int $totalPages,
        int $currentPage,
    )
    {
        $this->totalPages = $totalPages;
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

}