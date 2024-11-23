<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241122213902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cabinet (id SERIAL NOT NULL, office_id INT DEFAULT NULL, number INT NOT NULL, department VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4CED05B0FFA0C224 ON cabinet (office_id)');
        $this->addSql('CREATE TABLE employee (id VARCHAR(255) NOT NULL, fio VARCHAR(255) NOT NULL, specialization VARCHAR(255) NOT NULL, department VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE equipment (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE equipment_copy (id SERIAL NOT NULL, equipment_id INT DEFAULT NULL, employee_id VARCHAR(255) DEFAULT NULL, serialnum VARCHAR(255) NOT NULL, quality VARCHAR(255) NOT NULL, datebuy TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, dateexp TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_773E6A84517FE9FE ON equipment_copy (equipment_id)');
        $this->addSql('CREATE INDEX IDX_773E6A848C03F15C ON equipment_copy (employee_id)');
        $this->addSql('CREATE TABLE maintenance (id SERIAL NOT NULL, request_id INT DEFAULT NULL, equipment_copy_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F84F8E9427EB8A5 ON maintenance (request_id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E9DE0EE89D ON maintenance (equipment_copy_id)');
        $this->addSql('CREATE TABLE office (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, number_of_jobs INT NOT NULL, number_level INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE plan (id SERIAL NOT NULL, cabinet_id INT DEFAULT NULL, workspace_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, loc_x INT NOT NULL, loc_y INT NOT NULL, rotate INT NOT NULL, level_hum INT NOT NULL, length INT NOT NULL, width INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD5A5B7DD351EC ON plan (cabinet_id)');
        $this->addSql('CREATE INDEX IDX_DD5A5B7D82D40A1F ON plan (workspace_id)');
        $this->addSql('CREATE TABLE request (id SERIAL NOT NULL, employee_id VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3B978F9F8C03F15C ON request (employee_id)');
        $this->addSql('CREATE TABLE workspace (id SERIAL NOT NULL, cabinet_id INT DEFAULT NULL, employee_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D940019D351EC ON workspace (cabinet_id)');
        $this->addSql('CREATE INDEX IDX_8D9400198C03F15C ON workspace (employee_id)');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B0FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_copy ADD CONSTRAINT FK_773E6A84517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipment_copy ADD CONSTRAINT FK_773E6A848C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9DE0EE89D FOREIGN KEY (equipment_copy_id) REFERENCES equipment_copy (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D82D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workspace ADD CONSTRAINT FK_8D940019D351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workspace ADD CONSTRAINT FK_8D9400198C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cabinet DROP CONSTRAINT FK_4CED05B0FFA0C224');
        $this->addSql('ALTER TABLE equipment_copy DROP CONSTRAINT FK_773E6A84517FE9FE');
        $this->addSql('ALTER TABLE equipment_copy DROP CONSTRAINT FK_773E6A848C03F15C');
        $this->addSql('ALTER TABLE maintenance DROP CONSTRAINT FK_2F84F8E9427EB8A5');
        $this->addSql('ALTER TABLE maintenance DROP CONSTRAINT FK_2F84F8E9DE0EE89D');
        $this->addSql('ALTER TABLE plan DROP CONSTRAINT FK_DD5A5B7DD351EC');
        $this->addSql('ALTER TABLE plan DROP CONSTRAINT FK_DD5A5B7D82D40A1F');
        $this->addSql('ALTER TABLE request DROP CONSTRAINT FK_3B978F9F8C03F15C');
        $this->addSql('ALTER TABLE workspace DROP CONSTRAINT FK_8D940019D351EC');
        $this->addSql('ALTER TABLE workspace DROP CONSTRAINT FK_8D9400198C03F15C');
        $this->addSql('DROP TABLE cabinet');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_copy');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE office');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE workspace');
    }
}
