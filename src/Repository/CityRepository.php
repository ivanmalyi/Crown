<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\CityRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function saveCity(CityRequest $cityRequest): int
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into city (name, country_id) value (:name, :countryId)';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['name'=>$cityRequest->getCityName(), 'countryId'=>$cityRequest->getCountryId()]);

        return (int)$conn->lastInsertId();
    }

}
