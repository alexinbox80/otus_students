<?php

namespace App\Controller\Web\Lesson\UpdateLesson\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateLessonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min:8)]
        #[Assert\Length(max:128)]
        public readonly string $name,
        #[Assert\Length(min:8)]
        #[Assert\Length(max:255)]
        public readonly ?string $description,
    ) {
    }
}
