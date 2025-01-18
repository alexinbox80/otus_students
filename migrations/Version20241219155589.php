<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219155589 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert fake data to database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (1, \'admin\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'["ROLE_ADMIN"]\', true,  NOW(), NOW());');
        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (2, \'manager\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'["ROLE_MANAGER"]\', true,  NOW(), NOW());');
        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (3, \'teacher\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'["ROLE_TEACHER"]\', true,  NOW(), NOW());');

        $this->addSql('INSERT INTO manager (id, user_id, last_name, first_name, middle_name, phone, email, created_at, updated_at) VALUES (1, 2, \'Менеджер\', \'Иван\', \'Иванович\', \'79215556677\', \'manager@mail.ru\', NOW(), NOW());');
        $this->addSql('INSERT INTO teacher (id, user_id, last_name, first_name, middle_name, phone, email, created_at, updated_at) VALUES (1, 3, \'Учитель\', \'Петр\', \'Петрович\', \'79215556688\', \'teacher@mail.ru\', NOW(), NOW());');

        $this->addSql('SELECT setval(pg_get_serial_sequence(\'manager\', \'id\'), max(id)) FROM manager;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'teacher\', \'id\'), max(id)) FROM teacher;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'user\', \'id\'), max(id)) FROM "user";');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM "user" WHERE id in (1, 2, 3);');
        $this->addSql('DELETE FROM manager WHERE id in (1);');
        $this->addSql('DELETE FROM teacher WHERE id in (1);');
    }
}
