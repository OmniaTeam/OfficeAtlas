<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123084224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_copy ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment_copy DROP dateexp');
        $this->addSql('ALTER TABLE equipment_copy ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE equipment_copy ALTER model DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE equipment_copy ADD dateexp TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE equipment_copy DROP type');
        $this->addSql('ALTER TABLE equipment_copy ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE equipment_copy ALTER model SET NOT NULL');
    }
}
