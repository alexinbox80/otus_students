<?php

namespace UnitTests\Domain\Service\StudentService;

use App\Domain\Entity\Student;
use App\Domain\Entity\User;
use App\Domain\Model\CreatePhoneConfirmationCodeModel;
use App\Domain\Repository\StudentRepositoryInterface;
use App\Domain\Service\StudentService;
use App\Domain\Service\UserService;
use App\Tests\Support\UnitTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Mockery;
use Psr\Cache\InvalidArgumentException;
use Support\Helper\SetEntityField;
use Support\Helper\SetEntityId;
use Traversable;

class StudentServiceConfirmationPhoneCest
{
    private const CODE_DEFAULT = '111111';

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

        $createStudent = new Student(
            $createUser,
            'firstNameUpdate',
            'lastNameUpdate',
            'middleNameUpdate',
            'emailUpdate@email.ru',
            '79123456789'
        );
        $createStudent->setPhoneCode(self::CODE_DEFAULT);

        $createStudent->setCreatedAt();
        $createStudent->setUpdatedAt();

        SetEntityId::updateEntityId($createStudent, 1);
        SetEntityField::updateEntityField($createUser, 'student', $createStudent);

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class);
        $studentRepository->shouldIgnoreMissing();

        $userService = Mockery::mock(UserService::class);
        $userService
            ->shouldReceive('findUserByLogin')
            ->andReturn($createUser);

        return new StudentService($studentRepository, $userService);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[DataProvider('confirmationPhoneCases')]
    public function testConfirmationPhone(UnitTester $I, Example $example): void
    {
        $studentService = $this->make();
        $result = $studentService->confirmationPhone($example['phoneConfirmationCodeModel'], $example['login']);

        if($result)
            $I->assertTrue($result);
        else
            $I->assertFalse($result);
    }

    public static function confirmationPhoneCases(): Traversable
    {
        yield [
            'phoneConfirmationCodeModel' => new CreatePhoneConfirmationCodeModel(
                '123456'
            ),
            'login' => 'login',
        ];
        yield [
            'phoneConfirmationCodeModel' => new CreatePhoneConfirmationCodeModel(
                self::CODE_DEFAULT
            ),
            'login' => 'login',
        ];
    }
}
