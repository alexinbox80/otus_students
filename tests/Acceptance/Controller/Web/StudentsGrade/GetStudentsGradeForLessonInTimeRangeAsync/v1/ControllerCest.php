<?php

namespace AcceptanceTests\Controller\Web\StudentsGrade\GetStudentsGradeForLessonInTimeRangeAsync\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testGetStudentsGradeForLessonInTimeRangeAsyncAction(AcceptanceTester $I, Example $example): void
    {
        $I->amManager($I, $example['manager']['login'], $example['manager']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/get-students-grade-for-lesson-in-time-range-async', $example['dateTimeInterval']);

        if ($example['containsJson'] === null) {
            $I->canSeeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson(['success' => true, 'code' => HttpCode::OK]);
        } else {
            $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
            $I->seeResponseContains($example['response'][$example['containsJson']]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
                'dateTimeInterval' => [
                    'startDate' => '2025-02-23',
                    'endDate' => '2025-03-24'
                ],
                'containsJson' => null
            ],
            'negative' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
                'dateTimeInterval' => [
                    'startDate' => '2025-03-23',
                    'endDate' => '2025-02-24'
                ],
                'containsJson' => null,
            ],
            'emptyStartDate' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
                'dateTimeInterval' => [
                    'startDate' => '',
                    'endDate' => '2025-02-24'
                ],
                'containsJson' => 'startDate',
                'response' => ['startDate' => 'This value should be of type string.']
            ],
            'emptyEndDate' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
                'dateTimeInterval' => [
                    'startDate' => '2025-02-24',
                    'endDate' => ''
                ],
                'containsJson' => 'endDate',
                'response' => ['endDate' => 'This value should be of type string.']
            ],
            'emptyDate' => [
                'manager' => ['login' => 'manager', 'password' => '12345678'],
                'dateTimeInterval' => [
                    'startDate' => '',
                    'endDate' => ''
                ],
                'containsJson' => 'endDate',
                'response' => ['endDate' => 'This value should be of type string.']
            ]
        ];
    }
}
