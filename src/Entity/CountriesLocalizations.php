<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountriesLocalizationsRepository")
 */
class CountriesLocalizations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $countryId;

    /**
     * @ORM\Column(type="integer")
     */
    private $localizationId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titleName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tag;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): self
    {
        $this->countryId = $countryId;

        return $this;
    }

    public function getLocalizationId(): ?int
    {
        return $this->localizationId;
    }

    public function setLocalizationId(int $localizationId): self
    {
        $this->localizationId = $localizationId;

        return $this;
    }

    public function getTitleName(): ?string
    {
        return $this->titleName;
    }

    public function setTitleName(string $titleName): self
    {
        $this->titleName = $titleName;

        return $this;
    }

    public static function validation(array $data): self
    {
        $countryLocalization = new self();
        $countryLocalization->setTitleName(isset($data['TitleName']) ? $data['TitleName']: '');
        $countryLocalization->setTag(isset($data['Tag']) ? $data['Tag']: '');
        $countryLocalization->setId(isset($data['CountryLocalizationId']) ? (int)$data['CountryLocalizationId']: 0);

        return $countryLocalization;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
