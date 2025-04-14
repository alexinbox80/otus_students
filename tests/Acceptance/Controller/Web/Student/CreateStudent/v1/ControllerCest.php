<?php

namespace AcceptanceTests\Controller\Web\Student\CreateStudent\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Support\Helper\AutoIncrementImitator;

class ControllerCest
{
    /**
     * @dataProvider executeDataProvider
     */
    public function testCreateStudentAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/student', $example['student']);
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => ['login' => 'ivanov', 'password' => '12345678'],
                'student' => [
                    'userId' => AutoIncrementImitator::nextId(),
                    'firstName' => 'FirstName',
                    'lastName' => 'LastName',
                    'middleName' => 'MiddleName',
                    'email' => 'email@emailcreate.ru',
                    'phone' => '79123456789'
                ]
            ],
//            'emptyContacts' => [
//                'user' => ['login' => 'ivanov', 'password' => '12345678'],
//                'student' => [
//                    'userId' => AutoIncrementImitator::nextId(),
//                    'firstName' => 'FirstName',
//                    'lastName' => 'LastName',
//                    'middleName' => 'MiddleName',
//                    'email' => null,
//                    'phone' => null
//                ]
//            ],
            'emptyMiddleName' => [
                'user' => ['login' => 'ivanov', 'password' => '12345678'],
                'student' => [
                    'userId' => AutoIncrementImitator::nextId(),
                    'firstName' => 'FirstName',
                    'lastName' => 'LastName',
                    'middleName' => null,
                    'email' => 'email@emailcre.ru',
                    'phone' => '79123456789'
                ]
            ],
        ];
    }
}
