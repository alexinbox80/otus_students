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

        $output = $I->runSymfonyConsoleCommand(self::COMMAND, $params, $inputs, $example['exitCode']);
        $I->assertStringStartsWith($example['expected'], $output);
    }

    protected function executeDataProvider(): array
    {
        return [
            'negative' => ['option' => '','expected' => "Options are empty\n", 'exitCode' => 1],
            'course' => ['option' => '--course', 'expected' => "Success : \n", 'exitCode' => 0],
            'lesson' => ['option' => '--lesson', 'expected' => "Success : \n", 'exitCode' => 0],
            'skill' => ['option' => '--skill', 'expected' => "Success : \n", 'exitCode' => 0],
        ];
    }
}
