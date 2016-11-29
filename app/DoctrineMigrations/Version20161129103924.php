<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161129103924 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, teaser VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, role VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, stay VARCHAR(255) NOT NULL, meals VARCHAR(255) NOT NULL, min_duration INT NOT NULL, price INT NOT NULL, start_date VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisation CHANGE core_values core_values LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', CHANGE email_support email_support VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE program');
        $this->addSql('ALTER TABLE organisation CHANGE core_values core_values VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE email_support email_support VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
