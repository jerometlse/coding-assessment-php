<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329125940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "User" ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "User" ADD roles TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "User" ADD salt VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "User".roles IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "User" DROP password');
        $this->addSql('ALTER TABLE "User" DROP roles');
        $this->addSql('ALTER TABLE "User" DROP salt');
    }
}
