<?php

namespace AcceptanceTests\Controller\Web\Student\DeleteStudent\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;

class ControllerCest
{
    private static int $entityId;
    private static int $userId;
    private const AUTH_LOGIN = 'ivanov';
    private const AUTH_PASSWORD = '12345678';
    private const LOGIN = 'test_st_delete';
    private const PASSWORD = 'test_st_delete';
    private const ROLE_MANAGER = 'ROLE_STUDENT';
    private const FIRST_NAME = 'StudentFirstName';
    private const LAST_NAME = 'StudentLastName';
    private const MIDDLE_NAME = 'StudentMiddleName';
    private const EMAIL = 'student@email.ru';
    private const PHONE = '79113456789';

    /**
     * @throws Exception
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->amStudent($I, self::AUTH_LOGIN, self::AUTH_PASSWORD);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/user',
            [
                'login' => self::LOGIN . '-'. self::LOGIN,
                'password' => self::PASSWORD . '-' . self::PASSWORD,
                'isActive' => false,
                'roles' => [self::ROLE_MANAGER],
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$userId = $userId[0];
        $I->sendPost('/api/v1/student',
            [
                'userId' => self::$userId,
                'firstName' => self::FIRST_NAME,
                'lastName' => self::LAST_NAME,
                'middleName' => self::MIDDLE_NAME,
                'email' => self::EMAIL,
                'phone' => self::PHONE,
            ]);
        $firstUserId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$entityId = $firstUserId[0];
    }

    /**
     * @dataProvider executeDataProvider
     */
    public function testDeleteStudentAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/api/v1/student/' . self::$entityId);
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->seeResponseContainsJson(['success' => true, 'code' => HttpCode::OK]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => self::AUTH_LOGIN, 'password' => self::AUTH_PASSWORD],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
