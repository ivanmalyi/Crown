<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Localization;
use App\Entity\Product;
use App\Entity\ProductLocalization;
use App\Entity\ProductRequest;
use App\Entity\Statuses\ResponseStatus;

/**
 * Class ProductFacade
 * @package App\Facade
 */
class ProductFacade extends AbstractFacade
{
    /**
     * @param ProductRequest[] $productRequest
     *
     * @return int
     */
    public function saveProduct(array $productRequest): int
    {
        try {
            $productId = $this->managerRegistry->getRepository(Product::class)->saveProduct($productRequest[0]);

            foreach ($productRequest as $productLocale) {
                $productLocale->setProductId($productId);
                $localization = $this->managerRegistry->getRepository(Localization::class)
                    ->findLocalizationByTag($productLocale->getTag());
                $this->managerRegistry->getRepository(ProductLocalization::class)
                    ->saveProductLocalization($productLocale, $localization);
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }

    /**
     * @param array $productRequest
     * @return string
     */
    public function findProduct(array $productRequest): string
    {
        try {
            $params = $this->managerRegistry->getRepository(ProductLocalization::class)
                ->findProduct($productRequest[0]);

            $response = [];
            foreach ($params as $param) {
                $response[] = [
                    "ProductId"=>$param["product_id"],
                    "ProductName"=>$param["name"],
                    "Status"=>$param["status"],
                    "VIP"=>$param["vip"],
                    "Height"=>$param["height"],
                    "Year"=>$param["year"],
                    "Avatar"=>$param["avatar"],
                    "ColorId"=>$param["color_id"],
                    "CountryId"=>$param["country_id"],
                    "CityId"=>$param["city_id"],
                    "ProductLocalizationId"=>$param["product_localization_id"],
                    "LocalizationId"=>$param["localization_id"],
                    "ProductTitleName"=>$param["title_name"],
                    "Description"=>$param["description"],
                    "Tag"=>$param["tag"],
                ];
            }

            $response = json_encode($response);
        } catch (\Throwable $t) {
            $response = json_encode([]);
        }

        return $response;
    }

    /**
     * @param ProductRequest[] $productRequest
     * @return int
     */
    public function updateProduct(array $productRequest): int
    {
        try{
            $this->managerRegistry->getRepository(Product::class)->updateProduct($productRequest[0]);
            foreach ($productRequest as $product) {
                if ($product->getProductLocalizationId() !== 0) {
                    $this->managerRegistry->getRepository(ProductLocalization::class)->updateProductLocalizations($product);
                } else {
                    $localization = $this->managerRegistry->getRepository(Localization::class)
                        ->findLocalizationByTag($product->getTag());
                    $this->managerRegistry->getRepository(ProductLocalization::class)
                        ->saveProductLocalization($product, $localization);
                }

            }
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}