<?php

namespace App\Controller\Web\Lesson\UpdateLesson\v1;

use App\Controller\Web\Lesson\UpdateLesson\v1\Input\UpdateLessonDTO;
use App\Controller\Web\Lesson\UpdateLesson\v1\Output\UpdatedLessonDTO;
use App\Domain\Entity\Lesson;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: 'api/v1/lesson/{id}',
        name: 'web_update_lesson_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function __invoke(
        #[MapEntity(id: 'id')] Lesson $lesson,
        #[MapRequestPayload] UpdateLessonDTO $updateLessonDTO
    ): UpdatedLessonDTO
    {
        return $this->manager->updateLesson($lesson, $updateLessonDTO);
    }
}
