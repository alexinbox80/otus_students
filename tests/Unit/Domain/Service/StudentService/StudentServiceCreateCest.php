<?php

namespace UnitTests\Domain\Service\StudentService;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Domain\Entity\User;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use App\Domain\Service\StudentService;
use App\Domain\Service\UserService;
use App\Tests\Support\UnitTester;
use ReflectionException;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Traversable;
use Mockery;
use Psr\Cache\InvalidArgumentException;
use Support\Helper\SetEntityId;

class StudentServiceCreateCest
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
        $studentRepository
            ->shouldReceive('create')
            ->with(Mockery::on(static function($student) {
                SetEntityId::updateEntityId($student, 1);

                $student->setCreatedAt();
                $student->setUpdatedAt();
                return true;
            }))->andReturn(1);

        $userService = Mockery::mock(UserService::class);
        $userService->shouldReceive('find')->andReturn($createUser);

        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $eventDispatcher->shouldIgnoreMissing();

        return new StudentService($studentRepository, $userService, $eventDispatcher);
    }

    /**
     * @throws InvalidArgumentException|ReflectionException
     */
    #[DataProvider('createStudentCases')]
    public function testCreate(UnitTester $I, Example $example): void
    {
        $studentService = $this->make();
        $student = $studentService->create($example['createStudentModel']);

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

    public static function createStudentCases(): Traversable
    {
        yield [
            'createStudentModel' => new CreateStudentModel(
                1,
                'FirstName',
                'LastName',
                'MiddleName',
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
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
            'createStudentModel' => new CreateStudentModel(
                1,
                'FirstName',
                'LastName',
                null,
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
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
            'createStudentModel' => new CreateStudentModel(
                1,
                'FirstName',
                'LastName',
                'MiddleName',
                null,
                '78911234567',
                '123456',
                '654321'
            ),
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
            'createStudentModel' => new CreateStudentModel(
                1,
                'FirstName',
                'LastName',
                'MiddleName',
                'email@email.ru',
                null,
                '123456',
                '654321'
            ),
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
            'createStudentModel' => new CreateStudentModel(
                1,
                'FirstName',
                'LastName',
                null,
                null,
                null,
                '',
                ''
            ),
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
