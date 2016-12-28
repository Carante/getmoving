<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161227130008 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493540638B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649631C839D');
        $this->addSql('DROP INDEX UNIQ_8D93D649631C839D ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6493540638B ON user');
        $this->addSql('ALTER TABLE user ADD passport_id INT DEFAULT NULL, ADD criminal_record_id INT DEFAULT NULL, DROP police_report_file_id, DROP passport_file_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ABF410D0 FOREIGN KEY (passport_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C980E05 FOREIGN KEY (criminal_record_id) REFERENCES document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649ABF410D0 ON user (passport_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495C980E05 ON user (criminal_record_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ABF410D0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C980E05');
        $this->addSql('DROP INDEX UNIQ_8D93D649ABF410D0 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6495C980E05 ON user');
        $this->addSql('ALTER TABLE user ADD police_report_file_id INT DEFAULT NULL, ADD passport_file_id INT DEFAULT NULL, DROP passport_id, DROP criminal_record_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493540638B FOREIGN KEY (police_report_file_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649631C839D FOREIGN KEY (passport_file_id) REFERENCES document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649631C839D ON user (passport_file_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493540638B ON user (police_report_file_id)');
    }
}
