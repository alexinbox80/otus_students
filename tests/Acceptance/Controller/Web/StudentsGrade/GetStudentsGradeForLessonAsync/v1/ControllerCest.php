<?php

namespace AcceptanceTests\Controller\Web\StudentsGrade\GetStudentsGradeForLessonAsync\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentsGradeForLessonAsyncAction(AcceptanceTester $I, Example $example): void
    {
        $I->amManager($I, $example['manager']['login'], $example['manager']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/get-students-grade-for-lesson-async');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['success' => true, 'code' => HttpCode::OK]);
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
            ],
        ];
    }
}
