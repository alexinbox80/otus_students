<?php

namespace AcceptanceTests\Controller\Web\User\DeleteUser\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;

class ControllerCest
{
    private static int $entityId;
    private const AUTH_LOGIN = 'manager';
    private const AUTH_PASSWORD = '12345678';

    private const LOGIN = 'test_delete';
    private const PASSWORD = 'test_delete';
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
    public function testDeleteUserAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/api/v1/user/' . self::$entityId);
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
