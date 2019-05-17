<?php

namespace App\Repository;

use App\Entity\ProductLocalization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductLocalization|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLocalization|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLocalization[]    findAll()
 * @method ProductLocalization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLocalizationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductLocalization::class);
    }

    // /**
    //  * @return ProductLocalization[] Returns an array of ProductLocalization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductLocalization
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
