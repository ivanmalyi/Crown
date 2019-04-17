<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    /**
     * CountryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Country::class);
    }

    /**
     * @param string $name
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveCountry(string $name): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into country (name) value (:name)';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name]);

        return (int)$conn->lastInsertId();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllCountries()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, name from country';

        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $rows =$stmt->fetchAll();

        $countries = [];
        foreach ($rows as $row) {
            $countries[] = $this->inflate($row);
        }

        return $countries;
    }

    /**
     * @param $row
     * @return Country
     */
    private function inflate($row): Country
    {
        $country = new Country();
        $country->setId($row['id']);
        $country->setName($row['name']);

        return $country;
    }

    /**
     * @param string $name
     * @param int $id
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateCountry(string $name, int $id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update country
                set name = :name
                where id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(['name' => $name, 'id'=>$id]);
    }
}
