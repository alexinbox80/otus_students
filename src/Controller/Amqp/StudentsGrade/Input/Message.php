<?php

namespace App\Controller\Amqp\StudentsGrade\Input;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('numeric')]
        public readonly int $studentId,
        #[Assert\NotNull]
        #[Assert\Type('numeric')]
        public readonly int $entityId,
        public readonly ?DateTime $startDate = null,
        public readonly ?DateTime $endDate = null,
        #[Assert\Type('string')]
        #[Assert\Length(max: 128)]
        public readonly string $typeStudentsGrade
    )
    {
    }
}
