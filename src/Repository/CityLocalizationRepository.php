<?php

namespace App\Repository;

use App\Entity\CityLocalization;
use App\Entity\CityRequest;
use App\Entity\Localization;
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
    /**
     * CityLocalizationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CityLocalization::class);
    }

    /**
     * @param CityRequest $cityRequest
     * @param Localization $localization
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveCityLocalization(CityRequest $cityRequest, Localization $localization): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into city_localization (city_id, localization_id, title_name, tag) 
                value (:city_id, :localization_id, :title_name, :tag)';
        $stmt = $conn->prepare($sql);

       return $stmt->execute(
           [
               'city_id'=>$cityRequest->getCityId(),
               'localization_id'=>$localization->getId(),
               'title_name'=>$cityRequest->getCityTitleName(),
               'tag'=>$cityRequest->getTag()
           ]
       );
    }

    /**
     * @param CityRequest $cityRequest
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findCityLocalization(CityRequest $cityRequest)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select c.name, cl.id, cl.city_id, cl.title_name, cl.tag 
                from city_localization as cl
                left join city as c on c.id = cl.city_id
                where cl.city_id = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$cityRequest->getCityId()]);

        return $stmt->fetchAll();
    }

    /**
     * @param CityRequest $cityRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateCityLocalizations(CityRequest $cityRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update city_localization
                set title_name = :titleName, tag = :tag
                where city_id = :cityId and id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(
            [
                'titleName' => $cityRequest->getCityTitleName(),
                'cityId'=> $cityRequest->getCityId(),
                'tag'=>$cityRequest->getTag(),
                'id'=>$cityRequest->getCityTitleNameId()
            ]
        );
    }

    public function findCityWithLocalization(CityRequest $cityRequest, Localization $localization)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select cl.id, cl.city_id, cl.localization_id, cl.title_name, cl.tag 
                from city_localization as cl
                left join city as c on c.id = cl.city_id
                where c.country_id = :countryId and cl.localization_id = :localizationId';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['countryId'=>$cityRequest->getCountryId(), 'localizationId'=>$localization->getId()]);

        return $stmt->fetchAll();
    }
}
