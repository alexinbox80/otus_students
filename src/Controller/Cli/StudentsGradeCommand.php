<?php

namespace App\Controller\Cli;

use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: self::STUDENTS_GRADE_COMMAND_NAME, description: 'Calculate students scores', hidden: false)]
final class StudentsGradeCommand extends Command
{
    use LockableTrait;

    public const STUDENTS_GRADE_COMMAND_NAME = 'students:grade';
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(

    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('students:grade')
            ->addOption('course', 'c', InputOption::VALUE_NONE, 'Students scores for course')
            ->addOption('lesson', 'l', InputOption::VALUE_NONE, 'Students scores for lesson')
            ->addOption('skill', 's', InputOption::VALUE_NONE, 'Students scores for skill')
            ->addOption('time', 't', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Students scores for lesson in time range')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('<info>Command is already running.</info>');

            return self::SUCCESS;
        }

        $output->write("<info>Started: </info>");

        $course = $input->getOption('course');
        if ($course) {
            // call service here
        }

        $lesson = $input->getOption('lesson');
        if ($lesson) {
            // call service here
        }

        $skill = $input->getOption('skill');
        if ($skill) {
            // call service here
        }

        $time = $input->getOption('time');
        if (count($time) === 2) {

            $startDateTime = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $time[0]);
            if(!$startDateTime) {
                $output->writeln("<error>Invalid date or time format: </error> $time[0] Actual format is " . self::DATE_TIME_FORMAT . "\n");
                exit(1);
            }

            $endDateTime = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $time[1]);
            if(!$endDateTime) {
                $output->writeln("<error>Invalid date or time format: </error> $time[1] Actual format is " . self::DATE_TIME_FORMAT . "\n");
                exit(1);
            }

            if ($startDateTime && $endDateTime) {
                //dd($startDateTime, $endDateTime);
                // call service here
            }
        } else {
            $output->write("<error>Invalid number of dates</error>\n");
        }
//
//        $output->write('<info>Started</info>');
//        $result = $this->followerService->addFollowersSync($user, $login.$authorId, $count);

        $output->write("<info>Success</info>\n");

        return self::SUCCESS;
    }
}