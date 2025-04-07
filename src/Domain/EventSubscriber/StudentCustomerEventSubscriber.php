<?php

namespace App\Domain\EventSubscriber;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Domain\Event\Customer\CreateStudentEvent;
use App\Domain\Event\Customer\UpdateStudentEvent;
use App\Domain\Event\Customer\DeleteStudentEvent;
use App\Domain\Service\StudentService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StudentCustomerEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly SalesInterface $sales
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreateStudentEvent::class => 'onCreateStudent',
            UpdateStudentEvent::class => 'onUpdateStudent',
            DeleteStudentEvent::class => 'onDeleteStudent'
        ];
    }

    public function onCreateStudent(CreateStudentEvent $event): void
    {
        $student = $this->studentService->find($event->studentId);

        $this->sales->createCustomer(
            $student->getOId(),
            $student->getFirstName(),
            $student->getLastName(),
            $student->getEmail(),
        );
    }

    public function onUpdateStudent(UpdateStudentEvent $event): void
    {
        $student = $this->studentService->find($event->studentId);

        $this->sales->updateCustomer(
            $student->getOId(),
            $student->getFirstName(),
            $student->getLastName(),
            $student->getEmail(),
        );
    }

    public function onDeleteStudent(DeleteStudentEvent $event): void
    {
        $student = $this->studentService->find($event->studentId);

        $this->sales->deleteCustomer(
            $student->getOId()
        );
    }
}
