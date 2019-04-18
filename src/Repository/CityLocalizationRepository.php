<?php

namespace App\Repository;

use App\Entity\CityLocalization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CityLocalization|null find($id, $lockMode = null, $lockVersion = null)
 * @method CityLocalization|null findOneBy(array $criteria, array $orderBy = null)
 * @method CityLocalization[]    findAll()
 * @method CityLocalization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityLocalizationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CityLocalization::class);
    }

    // /**
    //  * @return CityLocalization[] Returns an array of CityLocalization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CityLocalization
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
