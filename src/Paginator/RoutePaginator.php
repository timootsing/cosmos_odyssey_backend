<?php

namespace App\Paginator;

use App\DTO\Response\MoonPhaseDTO;
use App\DTO\Response\PaginationDTO;
use App\DTO\Response\PaginationTableDTO;
use App\DTO\Response\RouteDTO;
use App\Map\RouteResponseMap;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class RoutePaginator
{
    protected const DEFAULT_PAGE = 1;

    protected const PAGE_SIZE = 20;


    public function paginate(Query $query, int $page): PaginationTableDTO
    {
        $paginator = new Paginator($query);
        $currentPage = $this->getPageNumber($page);
        $items = $paginator
            ->getQuery()
            ->setFirstResult(self::PAGE_SIZE * ($currentPage - 1))
            ->setMaxResults(self::PAGE_SIZE)
            ->getResult();

        $lastPage = $this->getLastPage($paginator);
        $mappedItems = $this->getMappedRoutes($items);

        return new PaginationTableDTO($mappedItems, new PaginationDTO($lastPage, $currentPage));
    }

    private function getLastPage(Paginator $paginator): int
    {
        return (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
    }

    private function getPageNumber(int $currentPage): int
    {
        return $currentPage < 1
            ? self::DEFAULT_PAGE
            : $currentPage;
    }
    private function getMappedRoutes($routes): array
    {
        $mappedRoutes = [];
        foreach ($routes as $route) {
            $mappedRoutes[] = RouteResponseMap::mapEntityToDTO($route);
        }

        return $mappedRoutes;
    }

}
