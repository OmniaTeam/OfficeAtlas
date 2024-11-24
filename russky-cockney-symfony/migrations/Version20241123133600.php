<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123133600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE map_objects_id_seq CASCADE');
        $this->addSql('DROP TABLE map_objects');
        $this->addSql('ALTER TABLE cabinet DROP CONSTRAINT fk_4ced05b0ffa0c224');
        $this->addSql('DROP INDEX idx_4ced05b0ffa0c224');
        $this->addSql('ALTER TABLE cabinet DROP office_id');
        $this->addSql('ALTER TABLE map_scheme ADD level INT NOT NULL');
        $this->addSql('ALTER TABLE map_scheme DROP x');
        $this->addSql('ALTER TABLE map_scheme DROP y');
        $this->addSql('ALTER TABLE map_scheme DROP width');
        $this->addSql('ALTER TABLE map_scheme DROP height');
        $this->addSql('ALTER TABLE map_scheme DROP type');
        $this->addSql('ALTER TABLE map_scheme ADD CONSTRAINT FK_FB675E77FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FB675E77FFA0C224 ON map_scheme (office_id)');
        $this->addSql('ALTER TABLE plan ADD map_scheme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plan ADD height INT NOT NULL');
        $this->addSql('ALTER TABLE plan DROP rotate');
        $this->addSql('ALTER TABLE plan DROP level_hum');
        $this->addSql('ALTER TABLE plan DROP length');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DC0113F3F FOREIGN KEY (map_scheme_id) REFERENCES map_scheme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DD5A5B7DC0113F3F ON plan (map_scheme_id)');
        $this->addSql('ALTER TABLE workspace ALTER status SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE map_objects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE map_objects (id SERIAL NOT NULL, x INT NOT NULL, y INT NOT NULL, width INT NOT NULL, height INT NOT NULL, type VARCHAR(255) NOT NULL, cabinet_id INT DEFAULT NULL, workspace_id INT DEFAULT NULL, map_scheme_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE workspace ALTER status DROP NOT NULL');
        $this->addSql('ALTER TABLE plan DROP CONSTRAINT FK_DD5A5B7DC0113F3F');
        $this->addSql('DROP INDEX IDX_DD5A5B7DC0113F3F');
        $this->addSql('ALTER TABLE plan ADD level_hum INT NOT NULL');
        $this->addSql('ALTER TABLE plan ADD length INT NOT NULL');
        $this->addSql('ALTER TABLE plan DROP map_scheme_id');
        $this->addSql('ALTER TABLE plan RENAME COLUMN height TO rotate');
        $this->addSql('ALTER TABLE map_scheme DROP CONSTRAINT FK_FB675E77FFA0C224');
        $this->addSql('DROP INDEX IDX_FB675E77FFA0C224');
        $this->addSql('ALTER TABLE map_scheme ADD y INT NOT NULL');
        $this->addSql('ALTER TABLE map_scheme ADD width INT NOT NULL');
        $this->addSql('ALTER TABLE map_scheme ADD height INT NOT NULL');
        $this->addSql('ALTER TABLE map_scheme ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE map_scheme RENAME COLUMN level TO x');
        $this->addSql('ALTER TABLE cabinet ADD office_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT fk_4ced05b0ffa0c224 FOREIGN KEY (office_id) REFERENCES office (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4ced05b0ffa0c224 ON cabinet (office_id)');
    }
}
