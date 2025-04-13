<?php

namespace App\Controller\Cli;

use App\Domain\Service\StudentGradeService;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: self::STUDENTS_GRADE_COMMAND_NAME, description: 'Calculate students scores', hidden: false)]
final class StudentsGradeCommand extends Command
{
    use LockableTrait;

    public const STUDENTS_GRADE_COMMAND_NAME = 'students:grade';
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private readonly StudentGradeService $studentGradeService,
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

        $course = $input->getOption('course');
        if ($course) {
            // call service here
            $totalGrade = $this->studentGradeService->getStudentGradeForCourse();
            $this->studentGradeService->getStudentGradeForCourseAsync();
            $output->write("<info>Success : </info>\n");
            $output->write("<info>Course :: " . json_encode($totalGrade, JSON_UNESCAPED_UNICODE) . "</info>\n");
        }

        $lesson = $input->getOption('lesson');
        if ($lesson) {
            // call service here
            $totalGrade = $this->studentGradeService->getStudentGradeForLesson();
            $this->studentGradeService->getStudentGradeForLessonAsync();
            $output->write("<info>Success : </info>\n");
            $output->write("<info>Lesson :: " . json_encode($totalGrade, JSON_UNESCAPED_UNICODE) . "</info>\n");
        }

        $skill = $input->getOption('skill');
        if ($skill) {
            // call service here
            $totalGrade = $this->studentGradeService->getStudentGradeForSkill();
            $this->studentGradeService->getStudentGradeForSkillAsync();
            $output->write("<info>Success : </info>\n");
            $output->write("<info>Skill :: " . json_encode($totalGrade, JSON_UNESCAPED_UNICODE) . "</info>\n");
        }

        $time = $input->getOption('time');
        if ($time) {
            if (count($time) === 2) {

                $startDateTime = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $time[0]);
                if(!$startDateTime) {
                    $output->writeln("<error>Invalid date or time format: </error> $time[0] Actual format is " . self::DATE_TIME_FORMAT . "\n");
                    return self::FAILURE;
                }

                $endDateTime = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $time[1]);
                if(!$endDateTime) {
                    $output->writeln("<error>Invalid date or time format: </error> $time[1] Actual format is " . self::DATE_TIME_FORMAT . "\n");
                    return self::FAILURE;
                }

                if ($startDateTime && $endDateTime) {
                    // call service here
                    $totalGrade = $this->studentGradeService->getStudentGradeForLessonInTimeRange($startDateTime, $endDateTime);
                    $this->studentGradeService->getStudentGradeForLessonInTimeRangeAsync($startDateTime, $endDateTime);
                    $output->write("<info>Success : </info>\n");
                    $output->write("<info>Lesson in time range :: " . json_encode($totalGrade, JSON_UNESCAPED_UNICODE) . "</info>\n");
                }
            } else {
                $output->write("<error>Invalid number of dates</error>\n");
                return self::FAILURE;
            }
        }

        if (!$course && !$lesson && !$skill && !count($time)) {
            $output->write("<error>Options are empty</error>\n");
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
