<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    /**
     * ProductRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param ProductRequest $productRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveProduct(ProductRequest $productRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into product (name, status, vip, height, year, avatar, color_id, country_id, city_id)
                value (:name, :status, :vip, :height, :year, :avatar, :color_id, :country_id, :city_id)';

        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'name' => $productRequest->getProductName(),
                'status' => $productRequest->getStatus(),
                'vip' => $productRequest->getVip(),
                'height' => $productRequest->getHeight(),
                'year' => $productRequest->getYear(),
                'avatar' => $productRequest->getAvatar(),
                'color_id' => $productRequest->getColorId(),
                'country_id' => $productRequest->getCountryId(),
                'city_id' => $productRequest->getCityId(),
            ]
        );

        return (int)$conn->lastInsertId();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllProducts()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, name from product';

        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $rows =$stmt->fetchAll();

        $products = [];
        foreach ($rows as $row) {
            $products[] = $this->inflate($row);
        }

        return $products;
    }

    /**
     * @param array $row
     * @return Product
     */
    private function inflate(array $row): Product
    {
        $product = new Product();
        $product->setId($row['id']);
        $product->setName($row['name']);

        return $product;
    }

    /**
     * @param ProductRequest $productRequest
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function updateProduct(ProductRequest $productRequest): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'update product
                set name=:name, status=:status, vip=:vip, height=:height, year=:year, avatar=:avatar, color_id=:color_id, 
                  country_id=:country_id, city_id=:city_id
                where id = :id';

        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'name'=>$productRequest->getProductName(),
                'status'=>$productRequest->getStatus(),
                'vip'=>$productRequest->getVip(),
                'height'=>$productRequest->getHeight(),
                'year'=>$productRequest->getYear(),
                'avatar'=>$productRequest->getAvatar(),
                'color_id'=>$productRequest->getColorId(),
                'country_id'=>$productRequest->getCountryId(),
                'city_id'=>$productRequest->getCityId(),
                'id'=>$productRequest->getProductId()
            ]
        );
    }

}
