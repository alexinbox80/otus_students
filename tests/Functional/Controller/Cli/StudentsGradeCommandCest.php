<?php

namespace FunctionalTests\Controller\Cli;

use App\Tests\Support\FunctionalTester;
use Codeception\Example;

class StudentsGradeCommandCest
{
    private const COMMAND = 'students:grade';

    /**
     * @dataProvider executeDataProvider
     */
    public function testExecuteReturnsResult(FunctionalTester $I, Example $example): void
    {
        $params = [$example['option']];
        $inputs = [];
        $output = $I->runSymfonyConsoleCommand(self::COMMAND, $params, $inputs);
        $I->assertStringEndsWith($example['expected'], $output);
    }

    protected function executeDataProvider(): array
    {
        return [
            'positive' => ['option' => '--course', 'expected' => "Started: Success\n"],
            'zero' => ['option' => null, 'expected' => "Started: Options are empty\n"],
//            'default' => ['followersCount' => null, 'option' => 'login3', 'expected' => "10 followers were created\n"],
//            'negative' => ['followersCount' => -1, 'option' => 'login_too', 'expected' => "Count should be positive integer\n"],
        ];
    }
}
