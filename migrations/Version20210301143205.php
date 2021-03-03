<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301143205 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gift (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', code VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_A47C990DD17F50A6 (uuid), INDEX IDX_A47C990DCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receiver (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, country_code VARCHAR(4) NOT NULL, UNIQUE INDEX UNIQ_3DB88C96D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE upload_order (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990DCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES receiver (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gift DROP FOREIGN KEY FK_A47C990DCD53EDB6');
        $this->addSql('DROP TABLE gift');
        $this->addSql('DROP TABLE receiver');
        $this->addSql('DROP TABLE upload_order');
    }
}
