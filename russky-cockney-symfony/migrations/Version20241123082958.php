<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123082958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_copy DROP CONSTRAINT fk_773e6a84517fe9fe');
        $this->addSql('DROP SEQUENCE equipment_id_seq CASCADE');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP INDEX idx_773e6a84517fe9fe');
        $this->addSql('ALTER TABLE equipment_copy DROP equipment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE equipment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE equipment (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE equipment_copy ADD equipment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment_copy ADD CONSTRAINT fk_773e6a84517fe9fe FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_773e6a84517fe9fe ON equipment_copy (equipment_id)');
    }
}
