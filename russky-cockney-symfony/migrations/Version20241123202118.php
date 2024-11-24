<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123202118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE maintenance_id_seq CASCADE');
        $this->addSql('ALTER TABLE maintenance DROP CONSTRAINT fk_2f84f8e9427eb8a5');
        $this->addSql('ALTER TABLE maintenance DROP CONSTRAINT fk_2f84f8e9de0ee89d');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('ALTER TABLE request ADD equipment_copy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD date_start TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FDE0EE89D FOREIGN KEY (equipment_copy_id) REFERENCES equipment_copy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3B978F9FDE0EE89D ON request (equipment_copy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE maintenance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE maintenance (id SERIAL NOT NULL, request_id INT DEFAULT NULL, equipment_copy_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2f84f8e9de0ee89d ON maintenance (equipment_copy_id)');
        $this->addSql('CREATE INDEX idx_2f84f8e9427eb8a5 ON maintenance (request_id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT fk_2f84f8e9427eb8a5 FOREIGN KEY (request_id) REFERENCES request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT fk_2f84f8e9de0ee89d FOREIGN KEY (equipment_copy_id) REFERENCES equipment_copy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE request DROP CONSTRAINT FK_3B978F9FDE0EE89D');
        $this->addSql('DROP INDEX IDX_3B978F9FDE0EE89D');
        $this->addSql('ALTER TABLE request DROP equipment_copy_id');
        $this->addSql('ALTER TABLE request DROP date_start');
        $this->addSql('ALTER TABLE request DROP date_end');
    }
}
