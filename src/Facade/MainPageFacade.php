<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\ColorsLocalizations;
use App\Entity\CountriesLocalizations;
use App\Entity\Localization;
use App\Entity\MainPageData;
use App\Entity\ProductLocalization;
use App\Entity\MainPageProduct;

class MainPageFacade extends AbstractFacade
{
    public function mainContent(string $tag, $filterRequest = null)
    {
        $mainPageData = new MainPageData();

        $localization = $this->managerRegistry->getRepository(Localization::class)
            ->findLocalizationByTag($tag);

        if (!is_null($filterRequest)) {
            $selectedProducts = $this->managerRegistry->getRepository(ProductLocalization::class)
                ->findSelectedProducts($filterRequest, $localization);
            foreach ($selectedProducts as $selectedProduct) {
                /**@var MainPageProduct $selectedProduct*/
                $selectedProduct->setImages($this->findImages($selectedProduct->getProductId()));
            }
            $mainPageData->setSelectedProduct($selectedProducts);

        } else {
            $selectedProducts = $this->managerRegistry->getRepository(ProductLocalization::class)
                ->findVipProducts($localization);
            foreach ($selectedProducts as $selectedProduct) {
                /**@var MainPageProduct $selectedProduct*/
                $selectedProduct->setImages($this->findImages($selectedProduct->getProductId()));
            }
            $mainPageData->setVipProduct($selectedProducts);
        }

        $randomProducts = $this->managerRegistry->getRepository(ProductLocalization::class)
            ->findRandomProducts($localization);

        foreach ($randomProducts as $randomProduct) {
            /**@var MainPageProduct $randomProduct*/
            $randomProduct->setImages($this->findImages($randomProduct->getProductId()));
        }
        $mainPageData->setRandomProduct($randomProducts);

        $localizations = $this->managerRegistry->getRepository(Localization::class)->findAllLocalizations();
        $mainPageData->setLocalizations($localizations);

        $colors = $this->managerRegistry->getRepository(ColorsLocalizations::class)
            ->findColorsByLocalizationId($localization);
        $mainPageData->setColors($colors);

        $countries = $this->managerRegistry->getRepository(CountriesLocalizations::class)
            ->findCountriesByLocalizationId($localization);

        $mainPageData->setCountries($countries);


        return $mainPageData;
    }

    private function findImages(int $productId): array
    {
        $productImagesUrl = __DIR__ . "/../../public/asset/img/products/" . "{$productId}/";
        $images = [];

        try {
            $files = scandir($productImagesUrl);
            foreach ($files as $file) {
                if (is_file($productImagesUrl . $file)) {
                    $imageType = exif_imagetype($productImagesUrl . $file);
                    if (in_array($imageType, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
                        $images[] = $file;
                    }
                }
            }
        } catch (\Exception $e) {
        }

        return $images;
    }
}