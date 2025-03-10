<?php

namespace App\Tests\Support;

use Exception;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    public function amAdmin(AcceptanceTester $I, string $login, string $password): void
    {
        $token = $this->getToken($I, $login, $password);
        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
    }

    public function amManager(AcceptanceTester $I, string $login, string $password): void
    {
        $token = $this->getToken($I, $login, $password);
        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
    }

    public function amTeacher(AcceptanceTester $I, string $login, string $password): void
    {
        $token = $this->getToken($I, $login, $password);
        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
    }

    public function amStudent(AcceptanceTester $I, string $login, string $password): void
    {
        $token = $this->getToken($I, $login, $password);
        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
    }

    private function getToken(AcceptanceTester $I, string $username, string $password): string
    {
        $authHeader = 'Basic ' . base64_encode($username . ':' . $password);
        $I->haveHttpHeader('Authorization', $authHeader);
        $I->sendPost('/api/v1/get-token');

        return json_decode($I->grabResponse())->token;
    }

    private function getRefreshToken(AcceptanceTester $I, string $token): string
    {
        $authHeader = 'Bearer ' . $token;
        $I->haveHttpHeader('Authorization', $authHeader);
        $I->sendPost('/api/v1/refresh-token');

        return json_decode($I->grabResponse())->token;
    }

    /**
     * @throws Exception
     */
    public function getCode(AcceptanceTester $I, array $manager, array $user, string $type = 'email'): string
    {
        $I->amStudent($I, $manager['login'], $manager['password']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/v1/user',
            [
                'login' => $user['login'],
                'password' => $user['password'],
                'isActive' => false,
                'roles' => $user['roles'],
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        $userId = $userId[0];

        $I->sendPost('/api/v1/student',
            [
                'userId' => $userId,
                'firstName' => $user['firstName'],
                'lastName' => $user['lastName'],
                'middleName' => $user['middleName'],
                'email' => $user['email'],
                'phone' => $user['phone'],
            ]);
        $userId = $I->grabDataFromResponseByJsonPath('$..id');
        $student = $I->grabEntryFromDatabase('student', ['id' => $userId[0]]);

        if ($type === 'email') {
            return (string)$student['email_code'];
        } else {
            return (string)$student['phone_code'];
        }
    }
}
