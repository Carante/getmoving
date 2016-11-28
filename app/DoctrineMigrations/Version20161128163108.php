<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128163108 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation CHANGE mission mission VARCHAR(255) DEFAULT NULL, CHANGE vision vision VARCHAR(255) DEFAULT NULL, CHANGE about about VARCHAR(255) NOT NULL, CHANGE email_support email_support VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation CHANGE mission mission LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE vision vision LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE about about LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE email_support email_support LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
