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

    /**
     * @param ProductRequest $productRequest
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findProduct(ProductRequest $productRequest)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select p.id as product_id, p.name, p.status, p.vip, p.height, p.year, p.avatar, p.color_id, p.country_id, 
                       p.city_id, pl.id as product_localization_id, pl.localization_id, pl.title_name, pl.description, pl.tag
                from product_localization as pl
                left join product as p on p.id = pl.product_id
                where pl.product_id = :product_id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['product_id'=>$productRequest->getProductId()]);

        return $stmt->fetchAll();
    }

    /**
     * @param ProductRequest $productRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateProductLocalizations(ProductRequest $productRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update product_localization
                set product_id=:product_id, tag=:tag, title_name=:title_name, 
                  description=:description
                where product_id = :product_id and id = :id';

        $stmt = $conn->prepare($sql);
        return $stmt->execute(
            [
                'product_id'=>$productRequest->getProductId(),
                'tag'=>$productRequest->getTag(),
                'title_name'=>$productRequest->getProductTitleName(),
                'description'=>$productRequest->getDescription(),
                'id'=>$productRequest->getProductLocalizationId()
            ]
        );
    }
}
