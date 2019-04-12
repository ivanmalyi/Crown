<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Localization;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Repository\RepositoryFactory;

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

    public function saveLocalization(Localization $localization)
    {
        $this->managerRegistry->getRepository(Localization::class)->saveLocalization($localization);
    }
}