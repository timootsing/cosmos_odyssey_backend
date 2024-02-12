<?php

namespace App\Repository;

use App\Entity\PriceList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * @extends ServiceEntityRepository<PriceList>
 *
 * @method PriceList|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceList|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceList[]    findAll()
 * @method PriceList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceListRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($registry, PriceList::class);
    }

    public function save(PriceList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PriceList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findLatestPriceList(): ?PriceList
    {
        return $this->createQueryBuilder('pl')
            ->orderBy('pl.validUntil', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function deleteExceedingPriceLists(): void
    {
        try {
            $totalPriceLists = $this->createQueryBuilder('pl')
                ->select('COUNT(pl.id)')
                ->getQuery()
                ->getSingleScalarResult();

            if ($totalPriceLists > 15) {
                $priceListsToDelete = $this->createQueryBuilder('pl')
                    ->orderBy('pl.validUntil', 'ASC')
                    ->setMaxResults($totalPriceLists - 15)
                    ->getQuery()
                    ->getResult();

                $entityManager = $this->getEntityManager();

                foreach ($priceListsToDelete as $priceList) {
                    $entityManager->remove($priceList);
                }

                $entityManager->flush();
            }
        } catch (Throwable $exception) {
            $this->logger->error('An error occurred while deleting expired Travel Prices', [
                'exception' => get_class($exception),
                'message' => $exception->getMessage()
            ]);
        }
    }

}
