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
        #[Assert\Type('string')]
        #[Assert\Length(max: 128)]
        public readonly string $typeStudentsGrade,
        #[Assert\Type('numeric')]
        public readonly ?int $entityId = null,
        public readonly ?DateTime $startDate = null,
        public readonly ?DateTime $endDate = null,
    )
    {
    }
}
