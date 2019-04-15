<?php
declare(strict_types=1);

namespace App\Entity;


/**
 * Class AdminData
 * @package App\Entity
 */
class AdminData
{
    /**
     * @var Localization[]
     */
    private $localizations;

    /**
     * @return Localization[]
     */
    public function getLocalizations(): array
    {
        return $this->localizations;
    }

    /**
     * @param Localization[] $localizations
     */
    public function setLocalizations(array $localizations): void
    {
        $this->localizations = $localizations;
    }
}