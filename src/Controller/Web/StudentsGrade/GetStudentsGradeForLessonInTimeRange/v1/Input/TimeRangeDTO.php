<?php

namespace App\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRange\v1\Input;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class TimeRangeDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type("\DateTimeInterface")]
        public DateTime $startDate,
        #[Assert\NotBlank]
        #[Assert\Type("\DateTimeInterface")]
        public DateTime $endDate,
    ) {
    }
}
