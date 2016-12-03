<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161202152023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, size INT NOT NULL, format VARCHAR(255) NOT NULL, date_uploaded DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, mission LONGTEXT DEFAULT NULL, vision LONGTEXT DEFAULT NULL, core_values LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', about LONGTEXT NOT NULL, punchline VARCHAR(255) DEFAULT NULL, email_support VARCHAR(255) NOT NULL, email_official VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, snapchat VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, googleplus VARCHAR(255) DEFAULT NULL, INDEX IDX_E6E132B4F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, teaser VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, role VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, stay VARCHAR(255) NOT NULL, meals VARCHAR(255) NOT NULL, min_duration INT NOT NULL, price INT NOT NULL, start_date DATE DEFAULT NULL, flex_start TINYINT(1) DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, sex TINYINT(1) NOT NULL, nationality VARCHAR(3) NOT NULL, phone INT NOT NULL, address_country VARCHAR(255) NOT NULL, address_region VARCHAR(255) DEFAULT NULL, address_zip INT NOT NULL, address_city VARCHAR(255) NOT NULL, address_street VARCHAR(255) NOT NULL, address_po_box VARCHAR(255) DEFAULT NULL, address_house_no VARCHAR(255) NOT NULL, address_co VARCHAR(255) DEFAULT NULL, edu_level_expected VARCHAR(255) NOT NULL, edu_current_place VARCHAR(255) NOT NULL, edu_current_program VARCHAR(255) NOT NULL, edu_future_place VARCHAR(255) DEFAULT NULL, edu_future_program VARCHAR(255) DEFAULT NULL, program_arrival DATE DEFAULT NULL, program_duration VARCHAR(255) DEFAULT NULL, is_notified TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, passport_file VARCHAR(255) DEFAULT NULL, plane_out_file VARCHAR(255) DEFAULT NULL, police_report_file VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_program (user_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_CAE0698EA76ED395 (user_id), INDEX IDX_CAE0698E3EB8070A (program_id), PRIMARY KEY(user_id, program_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisation ADD CONSTRAINT FK_E6E132B4F98F144A FOREIGN KEY (logo_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE user_program ADD CONSTRAINT FK_CAE0698EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_program ADD CONSTRAINT FK_CAE0698E3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisation DROP FOREIGN KEY FK_E6E132B4F98F144A');
        $this->addSql('ALTER TABLE user_program DROP FOREIGN KEY FK_CAE0698E3EB8070A');
        $this->addSql('ALTER TABLE user_program DROP FOREIGN KEY FK_CAE0698EA76ED395');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_program');
    }
}
