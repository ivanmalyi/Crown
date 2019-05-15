<?php

namespace App\Repository;

use App\Entity\Color;
use App\Entity\ColorRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Color|null find($id, $lockMode = null, $lockVersion = null)
 * @method Color|null findOneBy(array $criteria, array $orderBy = null)
 * @method Color[]    findAll()
 * @method Color[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColorRepository extends ServiceEntityRepository
{
    /**
     * ColorRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Color::class);
    }

    /**
     * @param ColorRequest $colorRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveColor(ColorRequest $colorRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into color (name) value (:name)';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $colorRequest->getName()]);

        return (int)$conn->lastInsertId();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllColors()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, name from color';

        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $rows =$stmt->fetchAll();

        $colors = [];
        foreach ($rows as $row) {
            $colors[] = $this->inflate($row);
        }

        return $colors;
    }

    /**
     * @param array $row
     * @return Color
     */
    private function inflate(array $row): Color
    {
        $color = new Color();
        $color->setName($row['name']);
        $color->setId((int)$row['id']);

        return $color;
    }

    /**
     * @param ColorRequest $colorRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateColor(ColorRequest $colorRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update color
                set name = :name
                where id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(['name' => $colorRequest->getName(), 'id'=>$colorRequest->getColorId()]);
    }
}
