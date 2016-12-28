<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161227140021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_participants DROP FOREIGN KEY FK_32CC83B5113E82B2');
        $this->addSql('ALTER TABLE program_participants ADD CONSTRAINT FK_32CC83B5113E82B2 FOREIGN KEY (partition_ticket_out_id) REFERENCES document (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_participants DROP FOREIGN KEY FK_32CC83B5113E82B2');
        $this->addSql('ALTER TABLE program_participants ADD CONSTRAINT FK_32CC83B5113E82B2 FOREIGN KEY (partition_ticket_out_id) REFERENCES program_participants (id)');
    }
}
