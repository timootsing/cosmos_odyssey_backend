<?php

namespace App\Repository;

use App\Entity\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Route>
 *
 * @method Route|null find($id, $lockMode = null, $lockVersion = null)
 * @method Route|null findOneBy(array $criteria, array $orderBy = null)
 * @method Route[]    findAll()
 * @method Route[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    public function save(Route $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Route $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQuery(
        int $originId,
        int $destinationId,
        ?int $providerId,
        string $sortBy,
        string $sortOrder,
    ): Query {
        $query = $this->createQueryBuilder('r')
            ->where('r.origin = :originId')
            ->andWhere('r.destination = :destinationId')
            ->setParameter('originId', $originId)
            ->setParameter('destinationId', $destinationId);;

        if ($providerId !== null) {
            $query
                ->leftJoin('r.flightsInRoute', 'f')
                ->andWhere('NOT EXISTS (
                    SELECT f2
                    FROM App\Entity\FlightsInRoute f2
                    WHERE f2.route = r.id
                    AND f2.provider != :providerId
                )')
                ->setParameter('providerId', $providerId);
        }

        $sortOrderDirection = ($sortOrder === "ASC") ? "ASC" : "DESC";

        switch ($sortBy) {
            case "distance":
                $query->orderBy('r.distance', $sortOrderDirection);
                break;
            case "travelTime":
                $query->orderBy('r.travelTime', $sortOrderDirection);
                break;
            default:
                $query->orderBy('r.price', $sortOrderDirection);
        }

        return $query->getQuery();
    }

}
