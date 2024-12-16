<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'unlocked_achievement')]
#[ORM\Entity]
#[ORM\Index(name: 'unlocked_achievement__student_id__ind', columns: ['student_id'])]
#[ORM\Index(name: 'unlocked_achievement__achievement_id__ind', columns: ['achievement_id'])]
#[ORM\UniqueConstraint(name: 'unlocked_achievement__student__achievement__uniq', fields: ['student', 'achievement'])]
#[ORM\HasLifecycleCallbacks]
class UnlockedAchievement implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'integer', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'unlockedAchievements')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: Achievement::class, inversedBy: 'unlockedAchievements')]
    #[ORM\JoinColumn(name: 'achievement_id', referencedColumnName: 'id')]
    private Achievement $achievement;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
    }

    public function getAchievement(): Achievement
    {
        return $this->achievement;
    }

    public function setAchievement(Achievement $achievement): void
    {
        $this->achievement = $achievement;
    }
}
