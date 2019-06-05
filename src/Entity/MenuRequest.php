<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class MenuRequest
 * @package App\Entity
 */
class MenuRequest
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $year;

    /**
     * @var string
     */
    private $height;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $search;

    /**
     * @var string
     */
    private $show;

    /**
     * @var string
     */
    private $contacts;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

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
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     */
    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return string
     */
    public function getShow(): string
    {
        return $this->show;
    }

    /**
     * @param string $show
     */
    public function setShow(string $show): void
    {
        $this->show = $show;
    }

    /**
     * @return string
     */
    public function getContacts(): string
    {
        return $this->contacts;
    }

    /**
     * @param string $contacts
     */
    public function setContacts(string $contacts): void
    {
        $this->contacts = $contacts;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param array $data
     * @return ProductRequest
     */
    public static function validation(array $data): self
    {
        $menuRequest = new self();

        $menuRequest->setTag(isset($data['Tag']) ? $data['Tag'] : '');
        $menuRequest->setLanguage(isset($data['Language']) ? $data['Language'] : '');
        $menuRequest->setFrom(isset($data['From']) ? $data['From'] : '');
        $menuRequest->setTo(isset($data['To']) ? $data['To'] : '');
        $menuRequest->setYear(isset($data['Year']) ? $data['Year'] : '');
        $menuRequest->setHeight(isset($data['Height']) ? $data['Height'] : '');
        $menuRequest->setColor(isset($data['Color']) ? $data['Color'] : '');
        $menuRequest->setCountry(isset($data['Country']) ? $data['Country'] : '');
        $menuRequest->setCity(isset($data['City']) ? $data['City'] : '');
        $menuRequest->setSearch(isset($data['Search']) ? $data['Search'] : '');
        $menuRequest->setShow(isset($data['Show']) ? $data['Show'] : '');
        $menuRequest->setContacts(isset($data['Contacts']) ? $data['Contacts'] : '');
        $menuRequest->setName(isset($data['Name']) ? $data['Name'] : '');
        $menuRequest->setDescription(isset($data['Description']) ? $data['Description'] : '');

        return $menuRequest;
    }
}