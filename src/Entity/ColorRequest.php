<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class ColorRequest
 * @package App\Entity
 */
/**
 * Class ColorRequest
 * @package App\Entity
 */
class ColorRequest
{
    /**
     * @var int
     */
    private $colorId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $colorLocalizationId;

    /**
     * @var int
     */
    private $localizationId;

    /**
     * @var string
     */
    private $titleName;

    /**
     * @var string
     */
    private $tag;

    /**
     * @return int
     */
    public function getColorId(): int
    {
        return $this->colorId;
    }

    /**
     * @param int $colorId
     */
    public function setColorId(int $colorId): void
    {
        $this->colorId = $colorId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getColorLocalizationId(): int
    {
        return $this->colorLocalizationId;
    }

    /**
     * @param int $colorLocalizationId
     */
    public function setColorLocalizationId(int $colorLocalizationId): void
    {
        $this->colorLocalizationId = $colorLocalizationId;
    }

    /**
     * @return int
     */
    public function getLocalizationId(): int
    {
        return $this->localizationId;
    }

    /**
     * @param int $localizationId
     */
    public function setLocalizationId(int $localizationId): void
    {
        $this->localizationId = $localizationId;
    }

    /**
     * @return string
     */
    public function getTitleName(): string
    {
        return $this->titleName;
    }

    /**
     * @param string $titleName
     */
    public function setTitleName(string $titleName): void
    {
        $this->titleName = $titleName;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @param array $data
     * @return ColorRequest
     */
    public static function validation(array $data): self
    {
        $colorRequest = new self();
        $colorRequest->setName(isset($data['Name']) ? $data['Name'] : '');
        $colorRequest->setTag(isset($data['Tag']) ? $data['Tag'] : '');
        $colorRequest->setTitleName(isset($data['TitleName']) ? $data['TitleName'] : '');
        $colorRequest->setColorId(isset($data['ColorId']) ? (int)$data['ColorId'] : 0);
        $colorRequest->setColorLocalizationId(isset($data['ColorLocalizationId']) ? (int)$data['ColorLocalizationId'] : 0);

        return $colorRequest;
    }

}