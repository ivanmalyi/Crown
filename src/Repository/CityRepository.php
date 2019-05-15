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
    /**
     * CityRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * @param CityRequest $cityRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveCity(CityRequest $cityRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into city (name, country_id) value (:name, :countryId)';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name'=>$cityRequest->getCityName(), 'countryId'=>$cityRequest->getCountryId()]);

        return (int)$conn->lastInsertId();
    }

    public function FindCitiesForCountry(CityRequest $cityRequest): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, country_id, name
                from city
                where country_id = :countryId';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['countryId'=>$cityRequest->getCountryId()]);

        $rows =$stmt->fetchAll();

        $cities = [];
        foreach ($rows as $row) {
            $cities[] = $this->inflate($row);
        }

        return $cities;
    }

    private function inflate($row): City
    {
        $city = new City();
        $city->setId((int)$row['id']);
        $city->setCountryId((int)$row['country_id']);
        $city->setName($row['name']);

        return $city;
    }

    public function updateCity(CityRequest $cityRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update city
                set name = :name
                where id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(['name' => $cityRequest->getCityName(), 'id'=>$cityRequest->getCityId()]);
    }

}
