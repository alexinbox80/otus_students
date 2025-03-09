<?php

namespace AcceptanceTests\Controller\Web\StudentsGrade\GetStudentsGradeForSkill\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentsGradeForSkillAction(AcceptanceTester $I, Example $example): void
    {
        $I->amManager($I, $example['manager']['login'], $example['manager']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/v1/get-students-grade-for-skill');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(['grade-for-skill' => []]);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer:>0',
            'studentName' => 'string',
            'skillName' => 'string',
            'grade' => 'float'
        ], '$.grade-for-skill[*]');
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
