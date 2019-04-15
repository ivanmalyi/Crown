<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Localization;
use App\Entity\Statuses\ResponseStatus;
use Doctrine\Common\Persistence\ManagerRegistry;

class LocalizationFacade
{
    private $managerRegistry;

    /**
     * LocalizationFacade constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function saveLocalization(Localization $localization): int
    {
        try {
            $this->managerRegistry->getRepository(Localization::class)->saveLocalization($localization);
            return ResponseStatus::SUCCESS;
        } catch (\Exception $e) {
            return ResponseStatus::ERROR;
        }
    }
}