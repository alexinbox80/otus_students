<?php

namespace UnitTests\Domain\Service\StudentService;

use alexinbox80\Shared\Domain\Model\OId;
use App\Domain\Entity\Student;
use App\Domain\Entity\User;
use App\Domain\Model\CreateEmailConfirmationCodeModel;
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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Traversable;

class StudentServiceConfirmationEmailCest
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
            Oid::next(),
            $createUser,
            'firstNameUpdate',
            'lastNameUpdate',
            'middleNameUpdate',
            'emailUpdate@email.ru',
            '79123456789'
        );
        $createStudent->setEmailCode(self::CODE_DEFAULT);

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

        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $eventDispatcher->shouldIgnoreMissing();

        return new StudentService($studentRepository, $userService, $eventDispatcher);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[DataProvider('confirmationEmailCases')]
    public function testConfirmationEmail(UnitTester $I, Example $example): void
    {
        $studentService = $this->make();
        $result = $studentService->confirmationEmail($example['emailConfirmationCodeModel'], $example['login']);

        if($result)
            $I->assertTrue($result);
        else
            $I->assertFalse($result);
    }

    public static function confirmationEmailCases(): Traversable
    {
        yield [
            'emailConfirmationCodeModel' => new CreateEmailConfirmationCodeModel(
                '123456'
            ),
            'login' => 'login',
        ];
        yield [
            'emailConfirmationCodeModel' => new CreateEmailConfirmationCodeModel(
                self::CODE_DEFAULT
            ),
            'login' => 'login',
        ];
    }
}
