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
}