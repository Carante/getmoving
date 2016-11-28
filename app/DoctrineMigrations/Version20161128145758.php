<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128145758 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation ADD address LONGTEXT DEFAULT NULL, CHANGE mission mission LONGTEXT DEFAULT NULL, CHANGE vision vision LONGTEXT DEFAULT NULL, CHANGE punchline punchline VARCHAR(255) DEFAULT NULL, CHANGE email_support email_support LONGTEXT DEFAULT NULL, CHANGE facebook facebook VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL, CHANGE linkedin linkedin VARCHAR(255) DEFAULT NULL, CHANGE youtube youtube VARCHAR(255) DEFAULT NULL, CHANGE snapchat snapchat VARCHAR(255) DEFAULT NULL, CHANGE instagram instagram VARCHAR(255) DEFAULT NULL, CHANGE googleplus googleplus VARCHAR(255) DEFAULT NULL, CHANGE email_oficial email_official VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation DROP address, CHANGE mission mission LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE vision vision LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE punchline punchline VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email_support email_support LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE facebook facebook VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE twitter twitter VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE linkedin linkedin VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE youtube youtube VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE snapchat snapchat VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE instagram instagram VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE googleplus googleplus VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email_official email_oficial VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
