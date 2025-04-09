<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407151238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers ADD customer_oid UUID NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX consumer__customer_oid__uniq ON customers (customer_oid) WHERE (deleted_at IS NULL)');
        $this->addSql('ALTER TABLE student ADD oid UUID NULL');
        $this->addSql('CREATE UNIQUE INDEX student__oid__ind ON student (oid) WHERE (deleted_at IS NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX consumer__customer_oid__uniq');
        $this->addSql('ALTER TABLE customers DROP customer_oid');
        $this->addSql('DROP INDEX student__oid__ind');
        $this->addSql('ALTER TABLE student DROP oid');
    }
}
