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
}
