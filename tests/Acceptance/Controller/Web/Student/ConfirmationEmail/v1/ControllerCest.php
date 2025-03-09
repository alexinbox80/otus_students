<?php

namespace AcceptanceTests\Controller\Web\Student\ConfirmationEmail\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;
use Support\Helper\AutoIncrementImitator;

class ControllerCest
{
    private static int $userId;
    private static int $emailCode;
    private const AUTH_LOGIN = 'ivanov';
    private const AUTH_PASSWORD = '12345678';
    private const LOGIN = 'test_student_em_confirm';
    private const PASSWORD = 'test_student_em_confirm';
    private const ROLE_STUDENT = 'ROLE_STUDENT';
    private const FIRST_NAME = 'StudentFirstName';
    private const LAST_NAME = 'StudentLastName';
    private const MIDDLE_NAME = 'StudentMiddleName';
    private const EMAIL = 'student1@email.ru';
    private const PHONE = '79113456789';

    /**
     * @throws Exception
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->amStudent($I, self::AUTH_LOGIN, self::AUTH_PASSWORD);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/user',
            [
                'login' => self::LOGIN,
                'password' => self::PASSWORD,
                'isActive' => false,
                'roles' => [self::ROLE_STUDENT],
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        self::$userId = $userId[0];

        $I->sendPost('/api/v1/student',
            [
                'userId' => self::$userId,
                'firstName' => self::FIRST_NAME . 'Test',
                'lastName' => self::LAST_NAME . 'Test',
                'middleName' => self::MIDDLE_NAME . 'Test',
                'email' => self::EMAIL,
                'phone' => self::PHONE,
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        $row = $I->grabEntryFromDatabase('student', ['id' => $userId[0]]);

        self::$emailCode = $row['email_code'];
    }

    /**
     * @dataProvider executeDataProvider
     */
    public function testStudentConfirmationEmailCodeAction(AcceptanceTester $I, Example $example): void
    {
        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/student/email-confirmation', [
            'emailCode' => self::$emailCode
        ]);

        if ($example['httpCode'] === HttpCode::OK) {
            $I->canSeeResponseCodeIs(HttpCode::OK);
            $I->seeResponseContainsJson([
                'success' => true,
                'message' => $example['message'],
            ]);
        }

        if ($example['httpCode'] === HttpCode::BAD_REQUEST) {
            $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
            $I->seeResponseContainsJson([
                'emailCode' => $example['message'],
            ]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
//            'positive' => [
//                'user' => [
//                    'login' => self::AUTH_LOGIN,
//                    'password' => self::AUTH_PASSWORD
//                ],
//                'message' => 'Email confirmation code is correct!',
//                'httpCode' => HttpCode::OK,
//            ],
            'negative' => [
                'user' => [
                    'login' => self::LOGIN,
                    'password' => self::PASSWORD
                ],
                'message' => 'This value should be of type null|string.',
                'httpCode' => HttpCode::BAD_REQUEST,
            ]
        ];
    }
}
