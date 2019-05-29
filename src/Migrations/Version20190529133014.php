<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190529133014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE date year INT NOT NULL');
        $this->addSql('ALTER TABLE countries_localizations MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE countries_localizations DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE countries_localizations CHANGE id country_localization_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE countries_localizations ADD PRIMARY KEY (country_localization_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries_localizations MODIFY country_localization_id INT NOT NULL');
        $this->addSql('ALTER TABLE countries_localizations DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE countries_localizations CHANGE country_localization_id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE countries_localizations ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE product CHANGE year date INT NOT NULL');
    }
}
