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

        $sql = 'insert into localization (name, tag) value (:name, :tag)';
        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'name' => $localization->getName(),
                'tag'=>$localization->getTag()
            ]
        );
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllLocalizations(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, name from localization';
        $stmt = $conn->prepare($sql);

         $stmt->execute([]);
        $rows = $stmt->fetchAll();

        $localizations = [];
        foreach ($rows as $row) {
            $localizations[] = $this->inflate($row);
        }

        return $localizations;
    }

    /**
     * @param int $id
     * @return Localization
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findLocalizationById(int $id): Localization
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, name, tag from localization
                where id = :id';
        $stmt = $conn->prepare($sql);

        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Localization
     */
    private function inflate(array $row): Localization
    {
        $localization = new Localization();
        $localization->setId((int)$row['id']);
        $localization->setName($row['name'] ?? '');
        $localization->setTag($row['tag'] ?? '');

        return $localization;
    }

    /**
     * @param Localization $localization
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateLocalization(Localization $localization): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update localization
                set name = :name, tag = :tag
                where id = :id';
        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            'id'=>$localization->getId(),
            'name'=>$localization->getName(),
            'tag'=>$localization->getTag()
        ]);
    }
}
