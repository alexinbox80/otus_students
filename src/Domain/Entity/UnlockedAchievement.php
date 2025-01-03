<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert as WebmozartAssert;

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

    #[ORM\ManyToOne(targetEntity: Achievement::class)]
    private Achievement $achievement;

    public function getId(): int
    {
        WebmozartAssert::notNull($this->id, sprintf('Id of Entity %s is null.', get_class($this)));

        return $this->id;
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

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'achievements' => $this->getAchievement()->toArray(),
        ];
    }
}
