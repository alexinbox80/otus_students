<?php

namespace AcceptanceTests\Controller\Web\Student\GetStudentById\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentByIdAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/get-student-by-id/' . $example['data']['id']);
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => 'ivanov', 'password' => '12345678'],
                'data' => [
                    'id' => 4,
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
