<?php

namespace AcceptanceTests\Controller\Web\Student\UpdateStudent\v1;

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
    private const LOGIN = 'test_st_create';
    private const PASSWORD = 'test_st_create';
    private const ROLE_STUDENT = 'ROLE_STUDENT';
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
                'roles' => [self::ROLE_STUDENT],
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$userId = $userId[0];

        $I->sendPost('/api/v1/student',
            [
                'userId' => self::$userId ,
                'firstName' => self::FIRST_NAME . 'Test',
                'lastName' => self::LAST_NAME . 'Test',
                'middleName' => self::MIDDLE_NAME . 'Test',
                'email' => self::EMAIL,
                'phone' => self::PHONE,
            ]);
        $firstUserId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$entityId = $firstUserId[0];
    }

    /**
     * @dataProvider executeDataProvider
     */
    public function testUpdateStudentAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPatch('/api/v1/student/' . self::$entityId, json_encode([
            'userId' => self::$userId,
            'firstName' => $example['data']['firstName'],
            'lastName' => $example['data']['lastName'],
            'middleName' => $example['data']['middleName'],
            'email' => $example['data']['email'],
            'phone' => $example['data']['phone'],
        ]));
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
            $I->seeResponseContainsJson(['id' => self::$entityId]);
            $I->seeResponseContainsJson(['firstName' => $example['data']['firstName']]);
            $I->seeResponseContainsJson(['lastName' => $example['data']['lastName']]);
            $I->seeResponseContainsJson(['middleName' => $example['data']['middleName']]);
            $I->seeResponseContainsJson(['email' => $example['data']['email']]);
            $I->seeResponseContainsJson(['phone' => $example['data']['phone']]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => self::AUTH_LOGIN, 'password' => self::AUTH_PASSWORD],
                'data' => [
                    'firstName' => self::FIRST_NAME,
                    'lastName' => self::LAST_NAME,
                    'middleName' => self::MIDDLE_NAME,
                    'email' => self::EMAIL,
                    'phone' => self::PHONE,
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
