<?php

declare(strict_types=1);

namespace App\Facade;


use Doctrine\Common\Persistence\ManagerRegistry;

class AbstractFacade
{
    protected $managerRegistry;

    /**
     * LocalizationFacade constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
}