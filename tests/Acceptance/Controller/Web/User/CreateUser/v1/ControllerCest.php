<?php

namespace AcceptanceTests\Controller\Web\User\CreateUser\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Support\Helper\AutoIncrementImitator;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testCreateUserAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/user', $example['data']);
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'isActiveNull' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'login' => 'testLogin' . AutoIncrementImitator::nextId(),
                    'password' => 'testLogin',
                    'isActive' => null,
                ],
                'httpCode' => HttpCode::BAD_REQUEST,
            ],
            'emptyLogin' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'login' => null,
                    'password' => 'testLogin',
                    'isActive' => null,
                ],
                'httpCode' => HttpCode::BAD_REQUEST,
            ],
            'emptyPassword' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'login' => 'testLogin' . AutoIncrementImitator::nextId(),
                    'password' => null,
                    'isActive' => null,
                ],
                'httpCode' => HttpCode::BAD_REQUEST,
            ],
            'isActiveTrue' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'login' => 'testLogin' . AutoIncrementImitator::nextId(),
                    'password' => 'testLogin',
                    'isActive' => true,
                ],
                'httpCode' => HttpCode::OK,
            ],
            'isActiveFalse' => [
                'user' => ['login' => 'manager', 'password' => '12345678'],
                'data' => [
                    'login' => 'testLogin' . AutoIncrementImitator::nextId(),
                    'password' => 'testLogin',
                    'isActive' => false,
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
