<?php

namespace AcceptanceTests\Controller\Web\StudentsGrade\GetStudentsGradeForLesson\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentsGradeForLessonAction(AcceptanceTester $I, Example $example): void
    {
        $I->amManager($I, $example['manager']['login'], $example['manager']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/get-students-grade-for-lesson');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['grade-for-lesson' => []]);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer:>0',
            'student-name' => 'string',
            'lesson-name' => 'string',
            'grade' => 'float'
        ], '$.grade-for-lesson[*]');
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
