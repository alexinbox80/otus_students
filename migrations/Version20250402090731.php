<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402090731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customers (id UUID NOT NULL, email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name_first_name VARCHAR(255) NOT NULL, name_last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE invoices (id UUID NOT NULL, status VARCHAR(255) NOT NULL, customer_id UUID NOT NULL, subscription_id UUID NOT NULL, due_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, paid_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, transaction_id VARCHAR(255) DEFAULT NULL, items JSON NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price_price_amount INT NOT NULL, price_price_currency VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price_price_amount INT NOT NULL, price_price_currency VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subscriptions (id UUID NOT NULL, customer_id UUID NOT NULL, product_id UUID NOT NULL, status VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price_price_amount INT NOT NULL, price_price_currency VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE subscriptions');
    }
}
