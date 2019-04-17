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
     * @param CountriesLocalizations[] $countryLocalizations
     * @param int $countryId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function addCountryLocalizations(array $countryLocalizations, int $countryId): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = /**@lang text*/
            'insert into countries_localizations (country_id, localization_id, title_name, tag) values ';

        $placeholders = [];
        foreach ($countryLocalizations as $key=>$countryLocalization) {
            $sql .= "(:country_id{$key}, :localization_id{$key}, :title_name{$key}, :tag{$key}),";
            $placeholders += [
                "country_id{$key}"=>$countryLocalization->getCountryId(),
                "localization_id{$key}"=>$countryLocalization->getLocalizationId(),
                "title_name{$key}"=>$countryLocalization->getTitleName(),
                "tag{$key}"=>$countryLocalization->getTag()
            ];
        }

        $stmt = $conn->prepare(rtrim($sql, ','));
        return $stmt->execute($placeholders);
    }
}
