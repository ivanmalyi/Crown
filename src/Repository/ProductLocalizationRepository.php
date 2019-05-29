<?php

namespace App\Repository;

use App\Entity\Localization;
use App\Entity\ProductLocalization;
use App\Entity\ProductRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductLocalization|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLocalization|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLocalization[]    findAll()
 * @method ProductLocalization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLocalizationRepository extends ServiceEntityRepository
{
    /**
     * ProductLocalizationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductLocalization::class);
    }

    /**
     * @param ProductRequest $productRequest
     * @param Localization $localization
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveProductLocalization(ProductRequest $productRequest, Localization $localization)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into product_localization (product_id, tag, localization_id, title_name, description)
                value (:product_id, :tag, :localization_id, :title_name, :description)';

        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'product_id' => $productRequest->getProductId(),
                'tag' => $localization->getTag(),
                'localization_id' => $localization->getId(),
                'title_name' => $productRequest->getProductTitleName(),
                'description' => $productRequest->getDescription(),
            ]
        );
    }
}
