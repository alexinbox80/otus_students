<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Traits\CreatedAtTrait;
use App\Domain\Entity\Traits\DeletedAtTrait;
use App\Domain\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Table(name: 'subscription')]
#[ORM\Entity]
#[ORM\Index(name: 'subscription__student_id__ind', columns: ['student_id'])]
#[ORM\Index(name: 'subscription__course_id__ind', columns: ['course_id'])]
#[ORM\UniqueConstraint(name: 'subscription__student__course__uniq', fields: ['student', 'course'])]
#[ORM\HasLifecycleCallbacks]
class Subscription implements EntityInterface, HasMetaTimestampsInterface
{
    use CreatedAtTrait, UpdatedAtTrait, DeletedAtTrait;

    #[ORM\Column(name: 'id', type: 'integer', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private Course $course;

    public function __construct(Student $student, Course $course)
    {
    }

    /**
     * @throws Exception
     */
    public function getId(): int
    {
        if (is_null($this->id)) {
            throw new Exception(sprintf('Id of Entity %s is null.', get_class($this)));
        }

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

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    /**
     * @throws Exception
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
            'course' => $this->getCourse()->toArray(),
        ];
    }
}
