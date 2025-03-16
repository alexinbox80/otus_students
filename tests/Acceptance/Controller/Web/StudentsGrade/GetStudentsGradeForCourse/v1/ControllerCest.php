<?php

namespace AcceptanceTests\Controller\Web\StudentsGrade\GetStudentsGradeForCourse\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentsGradeForCourseAction(AcceptanceTester $I, Example $example): void
    {
        $I->amManager($I, $example['manager']['login'], $example['manager']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/get-students-grade-for-course');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['grade-for-course' => []]);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer:>0',
            'studentName' => 'string',
            'courseName' => 'string',
            'grade' => 'float'
        ], '$.grade-for-course[*]');
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
