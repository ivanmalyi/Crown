<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorsLocalizationsRepository")
 */
class ColorsLocalizations
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
    private $colorId;

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

    public function getColorId(): ?int
    {
        return $this->colorId;
    }

    public function setColorId(int $colorId): self
    {
        $this->colorId = $colorId;

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
