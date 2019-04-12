<?php

namespace App\Repository;

use App\Entity\Localization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Localization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localization[]    findAll()
 * @method Localization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalizationRepository extends ServiceEntityRepository
{
    /**
     * LocalizationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Localization::class);
    }

    /**
     * @param Localization $localization
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveLocalization(Localization $localization): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into localization (name, tag, title) value (:name, :tag, :title)';
        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'name' => $localization->getName(),
                'tag'=>$localization->getTag(),
                'title'=>$localization->getTitle()
            ]
        );
    }
}
