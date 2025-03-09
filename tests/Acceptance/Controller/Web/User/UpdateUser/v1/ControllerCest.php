<?php

namespace AcceptanceTests\Controller\Web\User\UpdateUser\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testUpdateUsersAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPatch('/api/v1/user/' . $example['data']['id'], json_encode([
            'login' => $example['data']['login'],
            'password' => $example['data']['password'],
            'isActive' => $example['data']['isActive'],
            'roles' => $example['data']['roles'],
        ]));
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
            $I->seeResponseContainsJson(['id' => $example['data']['id']]);
            $I->seeResponseContainsJson(['login' => $example['data']['login']]);
            $I->seeResponseContainsJson(['roles' => $example['data']['roles']]);
            $I->seeResponseContainsJson(['isActive' => $example['data']['isActive']]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'id' => 7,
                    'login' => 'ivanov_test',
                    'password' => 'ivanov_test',
                    'isActive' => false,
                    'roles' => ['ROLE_MANAGER']
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
