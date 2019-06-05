<?php

namespace App\Repository;

use App\Entity\ColorRequest;
use App\Entity\ColorsLocalizations;
use App\Entity\Localization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ColorsLocalizations|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColorsLocalizations|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColorsLocalizations[]    findAll()
 * @method ColorsLocalizations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColorsLocalizationsRepository extends ServiceEntityRepository
{
    /**
     * ColorsLocalizationsRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ColorsLocalizations::class);
    }

    /**
     * @param ColorRequest $colorRequest
     * @param Localization $localization
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveColorLocalization(ColorRequest $colorRequest, Localization $localization): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into colors_localizations (color_id, localization_id, title_name, tag) 
                value (:color_id, :localization_id, :title_name, :tag)';
        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'color_id'=>$colorRequest->getColorId(),
                'localization_id'=>$localization->getId(),
                'title_name'=>$colorRequest->getTitleName(),
                'tag'=>$colorRequest->getTag()
            ]
        );
    }

    /**
     * @param ColorRequest $colorRequest
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findColor(ColorRequest $colorRequest): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select cl.id, cl.color_id, c.name, cl.title_name, cl.tag 
                from colors_localizations as cl
                left join color as c on c.id = cl.color_id
                where cl.color_id = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$colorRequest->getColorId()]);

        return $stmt->fetchAll();
    }

    /**
     * @param ColorRequest $colorRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateColorLocalizations(ColorRequest $colorRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update colors_localizations
                set title_name = :titleName, tag = :tag
                where color_id = :colorId and id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(
            [
                'titleName' => $colorRequest->getTitleName(),
                'colorId'=> $colorRequest->getColorId(),
                'tag'=>$colorRequest->getTag(),
                'id'=>$colorRequest->getColorLocalizationId()
            ]
        );
    }

    /**
     * @param Localization $localization
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findColorsByLocalizationId(Localization $localization): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select cl.id, cl.color_id, cl.localization_id, cl.title_name, cl.tag 
                from colors_localizations as cl
                where cl.localization_id = :localizationId';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['localizationId'=>$localization->getId()]);
        $rows = $stmt->fetchAll();

        $colors = [];
        foreach ($rows as $row) {
            $colors[] = $this->inflate($row);
        }

        return $colors;
    }

    /**
     * @param array $row
     * @return ColorsLocalizations
     */
    private function inflate(array $row): ColorsLocalizations
    {
        $colorsLocalizations = new ColorsLocalizations();
        $colorsLocalizations->setId((int)$row['id']);
        $colorsLocalizations->setColorId((int)$row['color_id']);
        $colorsLocalizations->setLocalizationId((int)$row['localization_id']);
        $colorsLocalizations->setTitleName($row['title_name']);
        $colorsLocalizations->setTag($row['tag']);

        return $colorsLocalizations;
    }
}
