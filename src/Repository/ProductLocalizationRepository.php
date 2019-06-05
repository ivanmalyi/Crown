<?php

namespace App\Repository;

use App\Entity\FilterRequest;
use App\Entity\Localization;
use App\Entity\MainPageProduct;
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

    /**
     * @param Localization $localization
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findVipProducts(Localization $localization): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select p.id as product_id, p.height, p.year, p.avatar, cl.title_name as color_name, pl.tag,
                  ctry_l.title_name as country_name, city_l.title_name as city_name, pl.title_name, pl.description
                from  product as p
                left join product_localization as pl on p.id = pl.product_id
                left join colors_localizations as cl on cl.color_id = p.color_id
                left join countries_localizations as ctry_l on ctry_l.country_id = p.country_id
                left join city_localization as city_l on city_l.city_id = p.city_id
                where p.vip = 1 and p.status = 1 and
                  pl.localization_id = :localizationId and cl.localization_id = :localizationId and ctry_l.localization_id = :localizationId and city_l.localization_id = :localizationId;';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['localizationId'=>$localization->getId()]);

        $rows = $stmt->fetchAll();

        $productsRequest = [];
        foreach ($rows as $row) {
            $productsRequest[] = $this->inflateMainPageProduct($row);
        }

        return $productsRequest;
    }

    /**
     * @param array $row
     * @return MainPageProduct
     */
    private function inflateMainPageProduct(array $row): MainPageProduct
    {
        $mainPageProduct = new MainPageProduct();

        $mainPageProduct->setProductId((int)$row['product_id']);
        $mainPageProduct->setHeight((int)$row['height']);
        $mainPageProduct->setYear((int)$row['year']);
        $mainPageProduct->setAvatar($row['avatar']);
        $mainPageProduct->setColor($row['color_name']);
        $mainPageProduct->setCountry($row['country_name']);
        $mainPageProduct->setCity($row['city_name']);
        $mainPageProduct->setTitleName($row['title_name']);
        $mainPageProduct->setDescription($row['description']);

        return $mainPageProduct;
    }

    /**
     * @param Localization $localization
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findRandomProducts(Localization $localization): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql1 = 'select count(*) as count from product';
        $stmt = $conn->prepare($sql1);
        $stmt->execute([]);
        $row = $stmt->fetch();

        $countProducts = (int)$row['count'];

        $i = 0;
        $randProductId = [];
        while (count($randProductId) < 10 and $i < 30) {
            $randProductId[] = rand(1, $countProducts);
            $randProductId = array_unique($randProductId);
            $i++;
        }

        $strRandId = implode(',', $randProductId);

        $sql2 = "select p.id as product_id, p.height, p.year, p.avatar, cl.title_name as color_name, pl.tag,
                  ctry_l.title_name as country_name, city_l.title_name as city_name, pl.title_name, pl.description
                from  product as p
                left join product_localization as pl on p.id = pl.product_id
                left join colors_localizations as cl on cl.color_id = p.color_id
                left join countries_localizations as ctry_l on ctry_l.country_id = p.country_id
                left join city_localization as city_l on city_l.city_id = p.city_id
                where p.id in ({$strRandId}) and p.status = 1 and
                  pl.localization_id = :localizationId and cl.localization_id = :localizationId and ctry_l.localization_id = :localizationId and city_l.localization_id = :localizationId";

        $stmt = $conn->prepare($sql2);
        $stmt->execute(['localizationId'=>$localization->getId()]);

        $rows = $stmt->fetchAll();

        $productsRequest = [];
        foreach ($rows as $row) {
            $productsRequest[] = $this->inflateMainPageProduct($row);
        }

        return $productsRequest;
    }

    public function findSelectedProducts(FilterRequest $filterRequest, Localization $localization): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $placeholders = ['localizationId'=>$localization->getId()];
        $sql = 'select p.id as product_id, p.height, p.year, p.avatar, cl.title_name as color_name, pl.tag,
                  ctry_l.title_name as country_name, city_l.title_name as city_name, pl.title_name, pl.description
                from  product as p
                left join product_localization as pl on p.id = pl.product_id
                left join colors_localizations as cl on cl.color_id = p.color_id
                left join countries_localizations as ctry_l on ctry_l.country_id = p.country_id
                left join city_localization as city_l on city_l.city_id = p.city_id
                where p.status = 1 and
                  pl.localization_id = :localizationId and cl.localization_id = :localizationId and ctry_l.localization_id = :localizationId and city_l.localization_id = :localizationId';

        if ($filterRequest->getYearFrom() != 0 and $filterRequest->getYearTo() != 0 and $filterRequest->getYearFrom() <= $filterRequest->getYearTo()) {
            $sql .= ' and p.year >= :yearFrom and p.year <= :yearTo';
            $placeholders += [
                'yearFrom'=>$filterRequest->getYearTo(),
                'yearTo'=>$filterRequest->getYearFrom()
            ];
        }

        if ($filterRequest->getHeightFrom() != 0 and $filterRequest->getHeightTo() != 0 and $filterRequest->getHeightFrom() <= $filterRequest->getHeightTo()) {
            $sql .= ' and p.height >= :heightFrom and p.height <= :heightTo';
            $placeholders += [
                'heightFrom'=>$filterRequest->getHeightFrom(),
                'heightTo'=>$filterRequest->getHeightTo()
            ];
        }

        if ($filterRequest->getColorId() != 0) {
            $sql .= ' and p.color_id = :colorId';
            $placeholders += [
                'colorId'=>$filterRequest->getColorId()
            ];
        }

        if ($filterRequest->getCountryId() != 0) {
            $sql .= ' and p.country_id = :countryId';
            $placeholders += [
                'countryId'=>$filterRequest->getCountryId()
            ];
        }

        if ($filterRequest->getCountryId() != 0) {
            $sql .= ' and p.city_id = :cityId';
            $placeholders += [
                'cityId'=>$filterRequest->getCityId()
            ];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($placeholders);

        $rows = $stmt->fetchAll();

        $productsRequest = [];
        foreach ($rows as $row) {
            $productsRequest[] = $this->inflateMainPageProduct($row);
        }

        return $productsRequest;
    }
}
