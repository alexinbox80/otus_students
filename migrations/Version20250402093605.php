<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402093605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS consumer__email__uniq ON customers (email) WHERE (deleted_at IS NULL)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS product__name__uniq ON products (name) WHERE (deleted_at IS NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS consumer__email__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS product__name__uniq');
    }
}
