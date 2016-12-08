<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209092711 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE address_country address_country VARCHAR(255) DEFAULT NULL, CHANGE address_zip address_zip INT DEFAULT NULL, CHANGE address_city address_city VARCHAR(255) DEFAULT NULL, CHANGE address_street address_street VARCHAR(255) DEFAULT NULL, CHANGE address_house_no address_house_no VARCHAR(255) DEFAULT NULL, CHANGE edu_level_expected edu_level_expected VARCHAR(255) DEFAULT NULL, CHANGE edu_current_place edu_current_place VARCHAR(255) DEFAULT NULL, CHANGE edu_current_program edu_current_program VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE address_country address_country VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE address_zip address_zip INT NOT NULL, CHANGE address_city address_city VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE address_street address_street VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE address_house_no address_house_no VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE edu_level_expected edu_level_expected VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE edu_current_place edu_current_place VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE edu_current_program edu_current_program VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
