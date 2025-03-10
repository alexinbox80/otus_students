<?php

namespace UnitTests\Domain\Service\StudentService;

use App\Domain\Entity\User;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Repository\StudentRepositoryInterface;
use App\Domain\Service\StudentService;
use App\Domain\Service\UserService;
use ReflectionException;
use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use Generator;
use Mockery;
use Psr\Cache\InvalidArgumentException;
use Support\Helper\SetEntityId;

class StudentServiceCreateTest extends Unit
{
    private static StudentService $studentService;

    /**
     * @throws ReflectionException
     */
    protected function _before(): void
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

        self::$studentService = new StudentService($studentRepository, $userService);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[DataProvider('createTestCases')]
    public function testCreate(CreateStudentModel $createStudentModel, array $expectedData): void
    {
        $studentService = self::$studentService;
        $student = $studentService->create($createStudentModel);

        $actualData = [
            'userId' => $student->getUserId(),
            'firstName' => $student->getFirstName(),
            'lastName' => $student->getLastName(),
            'middleName' => $student->getMiddleName(),
            'email' => $student->getEmail(),
            'phone' => $student->getPhone(),
        ];

        $this->assertEquals($expectedData, $actualData);
    }

    public static function createTestCases(): Generator
    {
        yield [
            new CreateStudentModel(
                1,
                'FirstNameName',
                'LastName',
                'MiddleName',
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
            [
                'userId' => 1,
                'firstName' => 'FirstNameName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => 'email@email.ru',
                'phone' => '78911234567'
            ]
        ];

        yield [
            new CreateStudentModel(
                1,
                'FirstNameName',
                'LastName',
                null,
                'email@email.ru',
                '78911234567',
                '123456',
                '654321'
            ),
            [
                'userId' => 1,
                'firstName' => 'FirstNameName',
                'lastName' => 'LastName',
                'middleName' => null,
                'email' => 'email@email.ru',
                'phone' => '78911234567'
            ]
        ];

        yield [
            new CreateStudentModel(
                1,
                'FirstNameName',
                'LastName',
                'MiddleName',
                null,
                '78911234567',
                '123456',
                '654321'
            ),
            [
                'userId' => 1,
                'firstName' => 'FirstNameName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => null,
                'phone' => '78911234567'
            ]
        ];

        yield [
            new CreateStudentModel(
                1,
                'FirstNameName',
                'LastName',
                'MiddleName',
                'email@email.ru',
                null,
                '123456',
                '654321'
            ),
            [
                'userId' => 1,
                'firstName' => 'FirstNameName',
                'lastName' => 'LastName',
                'middleName' => 'MiddleName',
                'email' => 'email@email.ru',
                'phone' => null
            ]
        ];

        yield [
            new CreateStudentModel(
                1,
                'FirstNameName',
                'LastName',
                null,
                null,
                null,
                '',
                ''
            ),
            [
                'userId' => 1,
                'firstName' => 'FirstNameName',
                'lastName' => 'LastName',
                'middleName' => null,
                'email' => null,
                'phone' => null
            ]
        ];
    }
}
