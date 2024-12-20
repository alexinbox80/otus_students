<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
use DateInterval;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @extends AbstractRepository<Student>
 */
class StudentRepository extends AbstractRepository
{
    public function create(Student $student): int
    {
        return $this->store($student);
    }
}
