<?php

namespace AcceptanceTests\Controller\Web\Student\ConfirmationPhone\v1;

use App\Tests\Support\AcceptanceTester;
use Codeception\Example;
use Codeception\Util\HttpCode;
use Exception;
use Support\Helper\AutoIncrementImitator;

class ControllerCest
{
    private const AUTH_LOGIN = 'ivanov';
    private const AUTH_PASSWORD = '12345678';
    private const LOGIN = 'test_student_ph_confirm';
    private const PASSWORD = 'test_student_ph_confirm';
    private const ROLE_STUDENT = 'ROLE_STUDENT';
    private const FIRST_NAME = 'StudentFirstName';
    private const LAST_NAME = 'StudentLastName';
    private const MIDDLE_NAME = 'StudentMiddleName';
    private const EMAIL = 'student2@email.ru';
    private const PHONE = '79114456789';

    /**
     * @dataProvider executeDataProvider
     * @throws Exception
     */
    public function testStudentConfirmationPhoneCodeAction(AcceptanceTester $I, Example $example): void
    {
        $manager = [
            'login' => self::AUTH_LOGIN,
            'password' => self::AUTH_PASSWORD,
        ];
        $user = [
            'login' => self::LOGIN,
            'password' => self::PASSWORD,
            'firstName' => self::FIRST_NAME . 'phTest',
            'lastName' => self::LAST_NAME . 'phTest',
            'middleName' => self::MIDDLE_NAME . 'phTest',
            'roles' => [self::ROLE_STUDENT],
            'email' => self::EMAIL,
            'phone' => self::PHONE,
        ];
        $phoneCode = $I->getCode($I, $manager, $user, 'phone');

        $I->amStudent($I, $example['user']['login'], $example['user']['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/student/phone-confirmation', [
            'phoneCode' => $phoneCode
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
                'phoneCode' => $example['message'],
            ]);
        }
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => [
                'user' => [
                    'login' => self::LOGIN,
                    'password' => self::PASSWORD
                ],
                'message' => 'Phone confirmation code is correct!',
                'httpCode' => HttpCode::OK,
            ],
//            'negative' => [
//                'user' => [
//                    'login' => self::LOGIN,
//                    'password' => self::PASSWORD
//                ],
//                'message' => 'This value should be of type null|string.',
//                'httpCode' => HttpCode::BAD_REQUEST,
//            ]
        ];
    }
}
