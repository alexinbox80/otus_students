<?php

namespace UnitTests\Domain\Service\UserService;

use App\Domain\Model\CreateUserModel;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepository;
use Codeception\Test\Unit;
use Generator;
use Mockery;
use Codeception\Attribute\DataProvider;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateTest extends Unit
{
    private static UserService $userService;
    private const PASSWORD_HASH = 'my_hash';
    private const DEFAULT_IS_ACTIVE = false;
    private const DEFAULT_ROLES = ['ROLE_USER'];

    protected function _before(): void
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldIgnoreMissing();
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordHasher->shouldReceive('hashPassword')
            ->andReturn(self::PASSWORD_HASH);

        self::$userService = new UserService($userRepository, $userPasswordHasher);
    }
    #[DataProvider('createTestCases')]
    public function testCreate(CreateUserModel $createUserModel, array $expectedData): void
    {
        $userService = self::$userService;
        $user = $userService->create($createUserModel);

        $actualData = [
            'login' => $user->getLogin(),
            'passwordHash' => $user->getPassword(),
            'isActive' => $user->isActive(),
            'roles' => $user->getRoles(),
        ];

        $this->assertEquals($expectedData, $actualData);
    }

    public static function createTestCases(): Generator
    {
        yield [
            new CreateUserModel(
                'someLogin',
                'somePassword',
            ),
            [
                'login' => 'someLogin',
                'passwordHash' => self::PASSWORD_HASH,
                'isActive' => self::DEFAULT_IS_ACTIVE,
                'roles' => self::DEFAULT_ROLES,
            ]
        ];

        yield [
            new CreateUserModel(
                'otherLogin',
                'someEmail',
            ),
            [
                'login' => 'otherLogin',
                'passwordHash' => self::PASSWORD_HASH,
                'isActive' => self::DEFAULT_IS_ACTIVE,
                'roles' => self::DEFAULT_ROLES,
            ]
        ];
    }
}
