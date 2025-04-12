<?php

namespace UnitTests\Domain\Service\StudentService;

use alexinbox80\Shared\Domain\Model\OId;
use App\Domain\Entity\Student;
use App\Domain\Entity\User;
use App\Domain\Model\UpdateStudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use App\Domain\Service\StudentService;
use App\Domain\Service\UserService;
use App\Tests\Support\UnitTester;
use ReflectionException;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Traversable;
use Mockery;
use Psr\Cache\InvalidArgumentException;
use Support\Helper\SetEntityId;

class StudentServiceUpdateCest
{
    /**
     * @throws ReflectionException
     */
    protected function make(): StudentService
    {
        $createUser = new User;
        $createUser->changeFields(
            'login',
            'password',
            false,
            'path/to/avatar',
            ['ROLE_MANAGER']
        );

        SetEntityId::updateEntityId($createUser, 1);

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class);
        $studentRepository->shouldIgnoreMissing();

        $userService = Mockery::mock(UserService::class);
        $userService->shouldReceive('find')->andReturn($createUser);

        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $eventDispatcher->shouldIgnoreMissing();

        return new StudentService($studentRepository, $userService, $eventDispatcher);
    }

    /**
     * @throws InvalidArgumentException|ReflectionException
     */
    #[DataProvider('updateStudentCases')]
    public function testUpdate(UnitTester $I, Example $example): void
    {
        $studentService = $this->make();
        $student = $studentService->update($example['student'], $example['updateStudentModel']);

        $actualData = [
            'userId' => $student->getUserId(),
            'firstName' => $student->getFirstName(),
            'lastName' => $student->getLastName(),
            'middleName' => $student->getMiddleName(),
            'email' => $student->getEmail(),
            'phone' => $student->getPhone(),
        ];

        $I->assertEquals($example['studentData'], $actualData);
    }

    public static function updateStudentCases(): Traversable
    {
        $user = new User;
        $user->changeFields(
            'loginUpdate',
            'passwordUpdate',
            false,
            'path/to/avatar',
            ['ROLE_MANAGER']
        );
        SetEntityId::updateEntityId($user, 1);

        $student = new Student(
            OId::next(),
            $user,
            'firstNameUpdate',
            'lastNameUpdate',
            'middleNameUpdate',
            'emailUpdate@email.ru',
            '79123456789'
        );
        $student->setCreatedAt();
        $student->setUpdatedAt();
        SetEntityId::updateEntityId($student, 1);

        yield [
            'updateStudentModel' => new UpdateStudentModel(
                1,
                'LastName',
                'FirstName',
                'MiddleName',
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
            'student' => $student,
            'studentData' => [
                'userId' => 1,
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => 'email@email.ru',
                'phone' => '78911234567'
            ]
        ];

        yield [
            'updateStudentModel' => new UpdateStudentModel(
                1,
                'LastName',
                'FirstName',
                null,
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
            'student' => $student,
            'studentData' => [
                'userId' => 1,
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
                'middleName' => null,
                'email' => 'email@email.ru',
                'phone' => '78911234567'
            ]
        ];

        yield [
            'updateStudentModel' => new UpdateStudentModel(
                1,
                'LastName',
                'FirstName',
                'MiddleName',
                null,
                '78911234567',
                '123456',
                '654321'
            ),
            'student' => $student,
            'studentData' => [
                'userId' => 1,
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => null,
                'phone' => '78911234567'
            ]
        ];

        yield [
            'updateStudentModel' => new UpdateStudentModel(
                1,
                'LastName',
                'FirstName',
                'MiddleName',
                'email@email.ru',
                null,
                '123456',
                '654321'
            ),
            'student' => $student,
            'studentData' => [
                'userId' => 1,
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => 'email@email.ru',
                'phone' => null
            ]
        ];

        yield [
            'updateStudentModel' => new UpdateStudentModel(
                1,
                'LastName',
                'FirstName',
                null,
                null,
                null,
                '',
                ''
            ),
            'student' => $student,
            'studentData' => [
                'userId' => 1,
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
                'middleName' => null,
                'email' => null,
                'phone' => null
            ]
        ];
    }
}
