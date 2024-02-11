<?php

namespace App\Repository;

use App\Entity\Planet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planet>
 *
 * @method Planet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planet[]    findAll()
 * @method Planet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planet::class);
    }

    public function save(Planet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Planet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByName(string $name): ?Planet
    {
        return $this->createQueryBuilder('p')
            ->where('p.name = :planetName')
            ->andWhere('aa.deletedAt IS NULL')
            ->setParameter('planetName', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $limit
     * @param int $page
     * @return array
     */
    /*public function findByPagination(int $limit, int $page): array
    {
        $query = $this->createQueryBuilder('mp')
            ->orderBy('mp.occurredAt', 'DESC');

        $offset = ($page - 1) * $limit;
        $query
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return $query
            ->getQuery()
            ->getResult();
    }*/

}
