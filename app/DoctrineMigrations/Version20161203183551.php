<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161203183551 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program ADD feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778460E4B879 FOREIGN KEY (feature_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_92ED778460E4B879 ON program (feature_id)');
        $this->addSql('ALTER TABLE program_participants DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE program_participants ADD PRIMARY KEY (program_id, user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778460E4B879');
        $this->addSql('DROP INDEX IDX_92ED778460E4B879 ON program');
        $this->addSql('ALTER TABLE program DROP feature_id');
        $this->addSql('ALTER TABLE program_participants DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE program_participants ADD PRIMARY KEY (user_id, program_id)');
    }
}
