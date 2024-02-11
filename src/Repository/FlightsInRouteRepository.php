<?php

namespace App\Repository;

use App\Entity\FlightsInRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FlightsInRoute>
 *
 * @method FlightsInRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightsInRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightsInRoute[]    findAll()
 * @method FlightsInRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightsInRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlightsInRoute::class);
    }

    public function save(FlightsInRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FlightsInRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
