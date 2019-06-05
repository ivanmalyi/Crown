<?php

namespace App\Repository;

use App\Entity\Localization;
use App\Entity\Menu;
use App\Entity\MenuRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    /**
     * MenuRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * @param MenuRequest $menu
     * @param Localization $localization
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function saveMenu(MenuRequest $menu, Localization $localization): bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'insert into menu (tag, localization_id, language, fromf, tot, year, height, color, country, city, search, shows, contacts, name, description) 
                value (:tag, :localization_id, :language, :fromf, :tot, :year, :height, :color, :country, :city, :search, :shows, :contacts, :name, :description)';

        $stmt = $conn->prepare($sql);

        return $stmt->execute(
            [
                'tag'=>$localization->getTag(),
                'localization_id'=>$localization->getId(),
                'language'=>$menu->getLanguage(),
                'fromf'=>$menu->getFrom(),
                'tot'=>$menu->getTo(),
                'year'=>$menu->getYear(),
                'height'=>$menu->getHeight(),
                'color'=>$menu->getColor(),
                'country'=>$menu->getCountry(),
                'city'=>$menu->getCity(),
                'search'=>$menu->getSearch(),
                'shows'=>$menu->getShow(),
                'contacts'=>$menu->getContacts(),
                'name'=>$menu->getName(),
                'description'=>$menu->getDescription(),
            ]
        );
    }

    /**
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function clearTable()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'truncate table menu';

        $stmt = $conn->prepare($sql);

        return $stmt->execute([]);
    }

    /**
     * @param Localization $localization
     * @return Menu
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findMenuByLocalization(Localization $localization): Menu
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, tag, localization_id, language, fromf, tot, year, height, color, country, city, search, shows, contacts, name, description
                from menu
                where localization_id = :localizationId';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['localizationId'=>$localization->getId()]);
        $row = $stmt->fetch();

        return $this->inflate($row);
    }

    /**
     * @param array $row
     * @return Menu
     */
    private function inflate(array $row): Menu
    {
        $menu = new Menu();
        $menu->setId((int)$row['id']);
        $menu->setTag($row['tag']);
        $menu->setLocalizationId((int)$row['localization_id']);
        $menu->setLanguage($row['language']);
        $menu->setFromf($row['fromf']);
        $menu->setTot($row['tot']);
        $menu->setYear($row['year']);
        $menu->setHeight($row['height']);
        $menu->setColor($row['color']);
        $menu->setCountry($row['country']);
        $menu->setCity($row['city']);
        $menu->setSearch($row['search']);
        $menu->setShows($row['shows']);
        $menu->setContacts($row['contacts']);
        $menu->setName($row['name']);
        $menu->setDescription($row['description']);

        return $menu;
    }

    public function findAllMenus(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select id, tag, localization_id, language, fromf, tot, year, height, color, country, city, search, shows, contacts, name, description
                from menu';

        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        $rows = $stmt->fetchAll();

        $menus = [];
        foreach ($rows as $row) {
            $menus[] = $this->inflate($row);
        }

        return $menus;
    }
}
