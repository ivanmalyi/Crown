<?php

namespace App\Repository;

use App\Entity\CountriesLocalizations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CountriesLocalizations|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountriesLocalizations|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountriesLocalizations[]    findAll()
 * @method CountriesLocalizations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountriesLocalizationsRepository extends ServiceEntityRepository
{
    /**
     * CountriesLocalizationsRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CountriesLocalizations::class);
    }

    /**
     * @param CountriesLocalizations $countryLocalization
     * @param int $countryId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function addCountryLocalizations(CountriesLocalizations $countryLocalization, int $countryId): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into countries_localizations (country_id, localization_id, title_name, tag) 
                value (:country_id, :localization_id, :title_name, :tag) ';

            $placeholders = [
                "country_id"=>$countryLocalization->getCountryId(),
                "localization_id"=>$countryLocalization->getLocalizationId(),
                "title_name"=>$countryLocalization->getTitleName(),
                "tag"=>$countryLocalization->getTag()
            ];


        $stmt = $conn->prepare($sql);
        return $stmt->execute($placeholders);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findCountry(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select cl.country_id, c.name, cl.title_name, cl.tag , cl.id
                from countries_localizations as cl
                left join country as c on c.id = cl.country_id
                where cl.country_id = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$id]);

        return $stmt->fetchAll();
    }

    /**
     * @param CountriesLocalizations $countriesLocalizations
     * @param int $countryId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateCountryLocalization(CountriesLocalizations $countriesLocalizations, int $countryId): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update countries_localizations
                set title_name = :titleName, tag = :tag
                where country_id = :countryId and id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(
            [
                'titleName' => $countriesLocalizations->getTitleName(),
                'countryId'=> $countryId,
                'tag'=>$countriesLocalizations->getTag(),
                'id'=>$countriesLocalizations->getCountryLocalizationId()
            ]
        );
    }
}
