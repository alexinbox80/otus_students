<?php

namespace AcceptanceTests\Controller\Web\Student\ConfirmationEmail\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;

class ControllerCest
{
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
     * @dataProvider executeDataProvider
     * @throws Exception
     */
    public function testStudentConfirmationEmailCodeAction(AcceptanceTester $I, Example $example): void
    {
        $manager = [
            'login' => self::AUTH_LOGIN,
            'password' => self::AUTH_PASSWORD,
        ];
        $user = [
            'login' => self::LOGIN,
            'password' => self::PASSWORD,
            'firstName' => self::FIRST_NAME . 'emTest',
            'lastName' => self::LAST_NAME . 'emTest',
            'middleName' => self::MIDDLE_NAME . 'emTest',
            'roles' => [self::ROLE_STUDENT],
            'email' => self::EMAIL,
            'phone' => self::PHONE,
        ];
        $emailCode = $I->getCode($I, $manager, $user);

        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPost('/api/v1/student/email-confirmation', [
            'emailCode' => $emailCode,
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

    /**
     * @throws Exception
     */
    protected function executeDataProvider(): array
    {
        return [
//            'negative' => [
//                'user' => [
//                    'login' => self::LOGIN,
//                    'password' => self::PASSWORD
//                ],
//                'message' => 'Email confirmation code is mismatched!',
//                'httpCode' => HttpCode::BAD_REQUEST,
//            ],
            'positive' => [
                'user' => [
                    'login' => self::LOGIN,
                    'password' => self::PASSWORD
                ],
                'message' => 'Email confirmation code is correct!',
                'httpCode' => HttpCode::OK
            ],
        ];
    }
}
