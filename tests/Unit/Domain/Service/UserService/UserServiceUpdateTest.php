<?php

namespace UnitTests\Domain\Service\UserService;

use App\Domain\Entity\User;
use App\Domain\Model\UpdateUserModel;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepository;
use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use Mockery;
use Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceUpdateTest extends Unit
{
    private static UserService $userService;
    private const PASSWORD_HASH = 'my_hash';
    private const DEFAULT_IS_ACTIVE = false;
    private const DEFAULT_ROLES = 'ROLE_USER';

    protected function _before(): void
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldIgnoreMissing();
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordHasher->shouldReceive('hashPassword')
            ->andReturn(self::PASSWORD_HASH);

        self::$userService = new UserService($userRepository, $userPasswordHasher);
    }

    #[DataProvider('updateTestCases')]
    public function testUpdate(UpdateUserModel $updateUserModel, array $expectedData): void
    {
        $userService = self::$userService;
        $createUser = new User;
        $createUser->changeFields(
            'login',
            'password',
            false,
            'path/to/avatar',
            ['ROLE_MANAGER']
        );
        $user = $userService->update($createUser, $updateUserModel);

        $actualData = [
            'login' => $user->getLogin(),
            'passwordHash' => $user->getPassword(),
            'isActive' => $user->isActive(),
            'roles' => $user->getRoles(),
        ];

        $this->assertEquals($expectedData, $actualData);
    }

    public static function updateTestCases(): Generator
    {
        yield [
            new UpdateUserModel(
                'login_update',
                'password_update',
                false,
                ['ROLE_STUDENT'],
                'path/to/avatar',
            ),
            [
                'login' => 'login_update',
                'passwordHash' => self::PASSWORD_HASH,
                'isActive' => self::DEFAULT_IS_ACTIVE,
                'roles' => ['ROLE_STUDENT', self::DEFAULT_ROLES],
            ]
        ];
        yield [
            new UpdateUserModel(
                'other_login_update',
                'other_password_update',
                false,
                ['ROLE_STUDENT'],
                'path/to/avatar',
            ),
            [
                'login' => 'other_login_update',
                'passwordHash' => self::PASSWORD_HASH,
                'isActive' => self::DEFAULT_IS_ACTIVE,
                'roles' => ['ROLE_STUDENT', self::DEFAULT_ROLES],
            ]
        ];
    }
}
