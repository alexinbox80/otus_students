<?php

namespace App\Controller\Web\Lesson\DeleteLesson\v1;

use App\Controller\Web\Lesson\DeleteLesson\v1\Output\DeletedLessonDTO;
use App\Domain\Entity\Lesson;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpKernel\Attribute\AsController;
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
        name: 'web_delete_lesson_by_id_v1_invoke',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function __invoke(#[MapEntity(id: 'id')] Lesson $lesson): DeletedLessonDTO
    {
        return $this->manager->deleteLesson($lesson);
    }
}
