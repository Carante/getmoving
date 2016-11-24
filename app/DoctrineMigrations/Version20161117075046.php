<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161117075046 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(70) NOT NULL, middle_name VARCHAR(70) DEFAULT NULL, last_name VARCHAR(70) NOT NULL, date_of_birth DATE NOT NULL, sex INT NOT NULL, nationality VARCHAR(3) NOT NULL, passport_no VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address_country VARCHAR(84) NOT NULL, address_one VARCHAR(255) NOT NULL, address_two VARCHAR(255) DEFAULT NULL, address_house_no VARCHAR(255) NOT NULL, address_flat VARCHAR(255) DEFAULT NULL, address_zip VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_region VARCHAR(255) NOT NULL, address_co VARCHAR(255) DEFAULT NULL, edu_level_expected VARCHAR(255) NOT NULL, edu_place_current VARCHAR(255) NOT NULL, edu_program_current VARCHAR(255) NOT NULL, edu_place_future VARCHAR(255) NOT NULL, edu_program_future VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_notified TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, passport_file VARCHAR(255) DEFAULT NULL, planeout_file VARCHAR(255) DEFAULT NULL, policereport_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_two (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FADCEBEDE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_two');
    }
}
