<?php

namespace AcceptanceTests\Controller\Web\Student\GetStudentPaginated\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentPaginatedAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/students?page=' . $example['data']['page'] . '&perPage=' . $example['data']['perPage']);
        $I->canSeeResponseCodeIs($example['httpCode']);
        if ($example['httpCode'] === HttpCode::OK) {
            $I->seeResponseContainsJson(['students' => []]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => 'ivanov', 'password' => '12345678'],
                'data' => [
                    'page' => 0,
                    'perPage' => 10
                ],
                'httpCode' => HttpCode::OK,
            ]
        ];
    }
}
