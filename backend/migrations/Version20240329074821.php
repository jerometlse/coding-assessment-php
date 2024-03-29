<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329074821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE leisure_base_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE activity_category_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ActivityCategory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE LeisureBase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ActivityCategory (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE LeisureBase (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE LeisureBaseActivityCategory (leisureBaseId INT NOT NULL, activityCategoryId INT NOT NULL, PRIMARY KEY(leisureBaseId, activityCategoryId))');
        $this->addSql('CREATE INDEX IDX_C13740EA2AD47902 ON LeisureBaseActivityCategory (leisureBaseId)');
        $this->addSql('CREATE INDEX IDX_C13740EA79EE8E0B ON LeisureBaseActivityCategory (activityCategoryId)');
        $this->addSql('CREATE TABLE "User" (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE LeisureBaseActivityCategory ADD CONSTRAINT FK_C13740EA2AD47902 FOREIGN KEY (leisureBaseId) REFERENCES LeisureBase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE LeisureBaseActivityCategory ADD CONSTRAINT FK_C13740EA79EE8E0B FOREIGN KEY (activityCategoryId) REFERENCES ActivityCategory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ActivityCategory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE LeisureBase_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE leisure_base_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE activity_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE LeisureBaseActivityCategory DROP CONSTRAINT FK_C13740EA2AD47902');
        $this->addSql('ALTER TABLE LeisureBaseActivityCategory DROP CONSTRAINT FK_C13740EA79EE8E0B');
        $this->addSql('DROP TABLE ActivityCategory');
        $this->addSql('DROP TABLE LeisureBase');
        $this->addSql('DROP TABLE LeisureBaseActivityCategory');
        $this->addSql('DROP TABLE "User"');
    }
}
