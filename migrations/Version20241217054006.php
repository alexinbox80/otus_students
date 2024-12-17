<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217054006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'make indexes for tables';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS achievement__name__uniq ON achievement (name)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS completed_task__student_id__ind ON completed_task (student_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS completed_task__task_id__ind ON completed_task (task_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS  completed_task__grade__ind ON completed_task (grade)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS completed_task__student__task__uniq ON completed_task (student_id, task_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS course__name__uniq ON course (name)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS lesson__course_id__ind ON lesson (course_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS lesson__name__course__uniq ON lesson (name, course_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS percentage__task_id__ind ON percentage (task_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS percentage__skill_id__ind ON percentage (skill_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS percentage__task__skill__uniq ON percentage (task_id, skill_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS skill__name__uniq ON skill (name)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS student__user_id__uniq ON student (user_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS student__last_name__first_name__middle_name__ind ON student (last_name, first_name, middle_name)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS student__first_name__last_name__middle_name__ind ON student (first_name, last_name, middle_name)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS subscription__student_id__ind ON subscription (student_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS subscription__course_id__ind ON subscription (course_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS subscription__student__course__uniq ON subscription (student_id, course_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS task__lesson_id__ind ON task (lesson_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS task__name__lesson__uniq ON task (name, lesson_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS unlocked_achievement__student_id__ind ON unlocked_achievement (student_id)');
        $this->addSql('CREATE INDEX CONCURRENTLY IF NOT EXISTS unlocked_achievement__achievement_id__ind ON unlocked_achievement (achievement_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS unlocked_achievement__student__achievement__uniq ON unlocked_achievement (student_id, achievement_id)');
        $this->addSql('CREATE UNIQUE INDEX CONCURRENTLY IF NOT EXISTS user__login__uniq ON "user" (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS achievement__name__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS completed_task__student_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS completed_task__task_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS completed_task__grade__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS completed_task__student__task__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS course__name__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS lesson__course_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS lesson__name__course__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS percentage__task_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS percentage__skill_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS percentage__task__skill__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS skill__name__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS student__user_id__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS student__last_name__first_name__middle_name__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS student__first_name__last_name__middle_name__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS subscription__student_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS subscription__course_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS subscription__student__course__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS task__lesson_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS task__name__lesson__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS unlocked_achievement__student_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS unlocked_achievement__achievement_id__ind');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS unlocked_achievement__student__achievement__uniq');
        $this->addSql('DROP INDEX CONCURRENTLY IF EXISTS user__login__uniq');
    }
}
