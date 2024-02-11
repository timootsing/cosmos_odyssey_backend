<?php

namespace App\Repository;

use App\Entity\Leg;
use App\Entity\PriceList;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Leg>
 *
 * @method Leg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Leg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Leg[]    findAll()
 * @method Leg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leg::class);
    }

    public function save(Leg $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Leg $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
