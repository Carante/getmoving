<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161228145249 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation ADD core_value_one VARCHAR(255) DEFAULT NULL, ADD core_value_one_icon VARCHAR(255) DEFAULT NULL, ADD core_value_two VARCHAR(255) DEFAULT NULL, ADD core_value_two_icon VARCHAR(255) DEFAULT NULL, ADD core_value_three VARCHAR(255) DEFAULT NULL, ADD core_value_three_icon VARCHAR(255) DEFAULT NULL, ADD core_value_four VARCHAR(255) DEFAULT NULL, ADD core_value_four_icon VARCHAR(255) DEFAULT NULL, ADD core_value_five VARCHAR(255) DEFAULT NULL, ADD core_value_five_icon VARCHAR(255) DEFAULT NULL, DROP core_values');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation ADD core_values LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', DROP core_value_one, DROP core_value_one_icon, DROP core_value_two, DROP core_value_two_icon, DROP core_value_three, DROP core_value_three_icon, DROP core_value_four, DROP core_value_four_icon, DROP core_value_five, DROP core_value_five_icon');
    }
}
