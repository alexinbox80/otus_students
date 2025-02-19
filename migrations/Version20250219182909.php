<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219182909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD email_code VARCHAR(6) DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD email_confirmed BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE student ADD phone_code VARCHAR(6) DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD phone_confirmed BOOLEAN DEFAULT false NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP email_code');
        $this->addSql('ALTER TABLE student DROP email_confirmed');
        $this->addSql('ALTER TABLE student DROP phone_code');
        $this->addSql('ALTER TABLE student DROP phone_confirmed');
    }
}
