<?php

namespace App\Tests\Support;

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

    private function getToken(AcceptanceTester $I, string $username, string $password)
    {
        $authHeader = 'Basic ' . base64_encode($username . ':' . $password);
        $I->haveHttpHeader('Authorization', $authHeader);
        $I->sendPost('/api/v1/get-token');

        return json_decode($I->grabResponse())->token;
    }

    private function getRefreshToken(AcceptanceTester $I, string $token)
    {
        $authHeader = 'Bearer ' . $token;
        $I->haveHttpHeader('Authorization', $authHeader);
        $I->sendPost('/api/v1/refresh-token');

        return json_decode($I->grabResponse())->token;
    }
}
