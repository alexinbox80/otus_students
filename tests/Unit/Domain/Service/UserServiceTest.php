<?php

namespace UnitTests\Domain\Service;

use App\Domain\Model\CreateUserModel;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepository;
use Generator;
use Mockery;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Codeception\Test\Unit;

class UserServiceTest extends Unit
{
    private const PASSWORD_HASH = 'my_hash';
    private const DEFAULT_IS_ACTIVE = false;
    private const DEFAULT_ROLES = ['ROLE_USER'];

    /**
     * @dataProvider createTestCases
     */
    public function testCreate(CreateUserModel $createUserModel, array $expectedData): void
    {
        $userService = $this->prepareUserService();

        $user = $userService->create($createUserModel);

        $actualData = [
            'login' => $user->getLogin(),
            'passwordHash' => $user->getPassword(),
            'isActive' => $user->isActive(),
            'roles' => $user->getRoles(),
        ];
        static::assertSame($expectedData, $actualData);
    }

    public static function createTestCases(): Generator
    {
        yield [
            new CreateUserModel(
                'someLogin',
                'somePhone',
            ),
            [
                'login' => 'someLogin',
                'passwordHash' => self::PASSWORD_HASH,
                'isActive' => self::DEFAULT_IS_ACTIVE,
                'roles' => self::DEFAULT_ROLES,
            ]
        ];

//        yield [
//            new CreateUserModel(
//                'otherLogin',
//                'someEmail',
//            ),
//            [
//                'login' => 'otherLogin',
//                'passwordHash' => self::PASSWORD_HASH,
//                'isActive' => self::DEFAULT_IS_ACTIVE,
//                'roles' => self::DEFAULT_ROLES,
//            ]
//        ];
    }

    private function prepareUserService(): UserService
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldIgnoreMissing();
        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordHasher->shouldReceive('hashPassword')
            ->andReturn(self::PASSWORD_HASH);

        return new UserService($userRepository, $userPasswordHasher);
    }
}
