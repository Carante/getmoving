<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161226202017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76DEB3D4CE');
        $this->addSql('DROP INDEX UNIQ_D8698A76DEB3D4CE ON document');
        $this->addSql('ALTER TABLE document DROP particion_ticket_out_id');
        $this->addSql('ALTER TABLE program_participants ADD partition_ticket_out_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program_participants ADD CONSTRAINT FK_32CC83B5113E82B2 FOREIGN KEY (partition_ticket_out_id) REFERENCES program_participants (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32CC83B5113E82B2 ON program_participants (partition_ticket_out_id)');
        $this->addSql('ALTER TABLE user ADD passport_file_id INT DEFAULT NULL, ADD police_report_file_id INT DEFAULT NULL, DROP passport_file, DROP plane_out_file, DROP police_report_file');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649631C839D FOREIGN KEY (passport_file_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493540638B FOREIGN KEY (police_report_file_id) REFERENCES document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649631C839D ON user (passport_file_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493540638B ON user (police_report_file_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document ADD particion_ticket_out_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76DEB3D4CE FOREIGN KEY (particion_ticket_out_id) REFERENCES program_participants (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8698A76DEB3D4CE ON document (particion_ticket_out_id)');
        $this->addSql('ALTER TABLE program_participants DROP FOREIGN KEY FK_32CC83B5113E82B2');
        $this->addSql('DROP INDEX UNIQ_32CC83B5113E82B2 ON program_participants');
        $this->addSql('ALTER TABLE program_participants DROP partition_ticket_out_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649631C839D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493540638B');
        $this->addSql('DROP INDEX UNIQ_8D93D649631C839D ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6493540638B ON user');
        $this->addSql('ALTER TABLE user ADD passport_file VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD plane_out_file VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD police_report_file VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP passport_file_id, DROP police_report_file_id');
    }
}
