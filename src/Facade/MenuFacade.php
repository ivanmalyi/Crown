<?php

declare(strict_types=1);

namespace App\Facade;
use App\Entity\Localization;
use App\Entity\Menu;
use App\Entity\MenuRequest;
use App\Entity\Statuses\ResponseStatus;


/**
 * Class MenuFacade
 * @package App\Facade
 */
class MenuFacade extends AbstractFacade
{
    /**
     * @param MenuRequest[]
     * @return int
     */
    public function updateMenu(array $menuRequest): int
    {
        try{
            $this->managerRegistry->getRepository(Menu::class)->clearTable();
            foreach ($menuRequest as $menu) {
                $localization = $this->managerRegistry->getRepository(Localization::class)
                    ->findLocalizationByTag($menu->getTag());

                $this->managerRegistry->getRepository(Menu::class)
                    ->saveMenu($menu, $localization);


            }
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}