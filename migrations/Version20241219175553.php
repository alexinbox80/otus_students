<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219175553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert fake data to database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO course (id, name, description, created_at, updated_at) VALUES (1, \'английский язык\', \'развитие навыков владения английским языком\', NOW(), NOW());');
        $this->addSql('INSERT INTO course (id, name, description, created_at, updated_at) VALUES (2, \'разработка бэкэнда\', \'способы ускорения бэкэнд разработки\', NOW(), NOW());');
        $this->addSql('INSERT INTO course (id, name, description, created_at, updated_at) VALUES (3, \'дев опс\', \'подготовка окружения для групп разработки\', NOW(), NOW());');

        $this->addSql('INSERT INTO lesson (id, course_id, name, description, created_at, updated_at) VALUES (1, 1,\'разговорный английский язык\', \'развитие языковых навыков\', NOW(), NOW());');
        $this->addSql('INSERT INTO lesson (id, course_id, name, description, created_at, updated_at) VALUES (2, 2, \'фреймворк\', \'изучение средста разработки\', NOW(), NOW());');
        $this->addSql('INSERT INTO lesson (id, course_id, name, description, created_at, updated_at) VALUES (3, 3, \'виртуализауия в разработке\', \'навыки конфигурирования среды виртуализации\', NOW(), NOW());');

        $this->addSql('INSERT INTO task (id, lesson_id, name, description, created_at, updated_at) VALUES (1, 1, \'диалог с преподавателем на английском языке\', \'разговор с преподавателем на английском языке\', NOW(), NOW());');
        $this->addSql('INSERT INTO task (id, lesson_id, name, description, created_at, updated_at) VALUES (2, 2, \'создать бизнесс сущность студента\', \'навык использования языка программирования и БД\', NOW(), NOW());');
        $this->addSql('INSERT INTO task (id, lesson_id, name, description, created_at, updated_at) VALUES (3, 3, \'создать докер контейнер для отображения веб страниц\', \'навык конфигурирования и сборки докер контейнера\', NOW(), NOW());');

        $this->addSql('INSERT INTO skill (id, name, description, created_at, updated_at) VALUES (1, \'навык говорения\', \'навык необходим для аудирования\', NOW(), NOW());');
        $this->addSql('INSERT INTO skill (id, name, description, created_at, updated_at) VALUES (2, \'навык программирования\', \'навык необходим для курсов по программированию\', NOW(), NOW());');
        $this->addSql('INSERT INTO skill (id, name, description, created_at, updated_at) VALUES (3, \'навык администрирования ОС\', \'навык необходим для курсов по администрирванию ОС\', NOW(), NOW());');

        $this->addSql('INSERT INTO achievement (id, name, description, created_at, updated_at) VALUES (1, \'все задания в занятии выполнены на 10 баллов\', \'достижение за выполнение всех заданий\', NOW(), NOW());');
        $this->addSql('INSERT INTO achievement (id, name, description, created_at, updated_at) VALUES (2, \'доля оценок выше 9 больше 90%\', \'доля оценок за задания\', NOW(), NOW());');
        $this->addSql('INSERT INTO achievement (id, name, description, created_at, updated_at) VALUES (3, \'все задания сданы досрочно\', \'достижение за досрочную сдачу заданий\', NOW(), NOW());');

        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (1, \'ivanov\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'[]\', true,  NOW(), NOW());');
        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (2, \'petrov\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'[]\', true,  NOW(), NOW());');
        $this->addSql('INSERT INTO "user" (id, login, password, roles, isactive, created_at, updated_at) VALUES (3, \'sergeev\', \'$2a$15$h336rWce.PCPYKltaTA0G.c.c5abLMZlntW3Q/ZQusCtTDU9Rblca\', \'[]\', true,  NOW(), NOW());');

        $this->addSql('INSERT INTO student (id, user_id, last_name, first_name, middle_name, created_at, updated_at) VALUES (1, 1, \'Иванов\', \'Иван\', \'Иванович\', NOW(), NOW());');
        $this->addSql('INSERT INTO student (id, user_id, last_name, first_name, middle_name, created_at, updated_at) VALUES (2, 2, \'Петров\', \'Петр\', \'Петрович\', NOW(), NOW());');
        $this->addSql('INSERT INTO student (id, user_id, last_name, first_name, middle_name, created_at, updated_at) VALUES (3, 3, \'Сергеев\', \'Сергей\', \'Сергеевич\', NOW(), NOW());');

        $this->addSql('INSERT INTO completed_task (id, student_id, task_id, grade, description, created_at, updated_at, finished_at) VALUES (1, 1, 1, 10, \'оценка за выполненое задание\', NOW(), NOW(), NOW());');
        $this->addSql('INSERT INTO completed_task (id, student_id, task_id, grade, description, created_at, updated_at, finished_at) VALUES (2, 2, 2, 9, \'оценка за выполненое задание\', NOW(), NOW(), NOW());');
        $this->addSql('INSERT INTO completed_task (id, student_id, task_id, grade, description, created_at, updated_at, finished_at) VALUES (3, 3, 3, 8, \'оценка за выполненое задание\', NOW(), NOW(), NOW());');

        $this->addSql('INSERT INTO percentage (id, task_id, skill_id, percent, description, created_at, updated_at) VALUES (1, 1, 1, 70, \'вклад в итоговую оценку за навык\', NOW(), NOW());');
        $this->addSql('INSERT INTO percentage (id, task_id, skill_id, percent, description, created_at, updated_at) VALUES (2, 2, 2, 85, \'вклад в итоговую оценку за навык\', NOW(), NOW());');
        $this->addSql('INSERT INTO percentage (id, task_id, skill_id, percent, description, created_at, updated_at) VALUES (3, 3, 3, 60, \'вклад в итоговую оценку за навык\', NOW(), NOW());');

        $this->addSql('INSERT INTO subscription (id, student_id, course_id, created_at, updated_at) VALUES (1, 1, 1, NOW(), NOW());');
        $this->addSql('INSERT INTO subscription (id, student_id, course_id, created_at, updated_at) VALUES (2, 2, 2, NOW(), NOW());');
        $this->addSql('INSERT INTO subscription (id, student_id, course_id, created_at, updated_at) VALUES (3, 3, 3, NOW(), NOW());');

        $this->addSql('INSERT INTO unlocked_achievement (id, student_id, achievement_id, created_at, updated_at) VALUES (1, 1, 1, NOW(), NOW());');
        $this->addSql('INSERT INTO unlocked_achievement (id, student_id, achievement_id, created_at, updated_at) VALUES (2, 2, 2, NOW(), NOW());');
        $this->addSql('INSERT INTO unlocked_achievement (id, student_id, achievement_id, created_at, updated_at) VALUES (3, 3, 3, NOW(), NOW());');

        $this->addSql('SELECT setval(pg_get_serial_sequence(\'unlocked_achievement\', \'id\'), max(id)) FROM unlocked_achievement;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'subscription\', \'id\'), max(id)) FROM subscription;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'percentage\', \'id\'), max(id)) FROM percentage;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'completed_task\', \'id\'), max(id)) FROM completed_task;');

        $this->addSql('SELECT setval(pg_get_serial_sequence(\'student\', \'id\'), max(id)) FROM student;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'user\', \'id\'), max(id)) FROM "user";');

        $this->addSql('SELECT setval(pg_get_serial_sequence(\'task\', \'id\'), max(id)) FROM task;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'lesson\', \'id\'), max(id)) FROM lesson;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'course\', \'id\'), max(id)) FROM course;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'skill\', \'id\'), max(id)) FROM skill;');
        $this->addSql('SELECT setval(pg_get_serial_sequence(\'achievement\', \'id\'), max(id)) FROM achievement;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM unlocked_achievement WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM subscription WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM percentage WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM completed_task WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM student WHERE id in (1, 2, 3);');
        $this->addSql('DELETE FROM "user" WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM task WHERE id in (1, 2, 3);');
        $this->addSql('DELETE FROM lesson WHERE id in (1, 2, 3);');
        $this->addSql('DELETE FROM course WHERE id in (1, 2, 3);');

        $this->addSql('DELETE FROM skill WHERE id in (1, 2, 3);');
        $this->addSql('DELETE FROM achievement WHERE id in (1, 2, 3);');
    }
}
