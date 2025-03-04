<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case SendNotification = 'send_notification';
    case StudentsGrade = 'students_grade';
}
