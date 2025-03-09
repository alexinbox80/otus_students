<?php

namespace AcceptanceTests\Controller\Web\User\UpdateUser\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;

class ControllerCest
{
    private static int $entityId;
    private const AUTH_LOGIN = 'manager';
    private const AUTH_PASSWORD = '12345678';

    private const LOGIN = 'test_create';
    private const PASSWORD = 'test_create';
    private const ROLE_MANAGER = 'ROLE_MANAGER';

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
        $firstUserId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$entityId = $firstUserId[0];
    }

    /**
     * @dataProvider executeDataProvider
     */
    public function testUpdateUsersAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPatch('/api/v1/user/' . self::$entityId, json_encode([
            'login' => $example['data']['login'],
            'password' => $example['data']['password'],
            'isActive' => $example['data']['isActive'],
            'roles' => $example['data']['roles'],
        ]));
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
            $I->seeResponseContainsJson(['id' => self::$entityId]);
            $I->seeResponseContainsJson(['login' => $example['data']['login']]);
            $I->seeResponseContainsJson(['roles' => $example['data']['roles']]);
            $I->seeResponseContainsJson(['isActive' => $example['data']['isActive']]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => self::AUTH_LOGIN, 'password' => self::AUTH_PASSWORD],
                'data' => [
                    'login' => self::LOGIN,
                    'password' => self::PASSWORD,
                    'isActive' => false,
                    'roles' => [self::ROLE_MANAGER],
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
