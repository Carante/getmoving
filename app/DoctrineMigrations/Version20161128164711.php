<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128164711 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE organisation');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE identity (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, main_color VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, second_color VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, mission LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, vision LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, about LONGTEXT NOT NULL COLLATE utf8_unicode_ci, punchline VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, email_support VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, email_official VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, facebook VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, twitter VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, linkedin VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, youtube VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, snapchat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, instagram VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, googleplus VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, `values` LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }
}
