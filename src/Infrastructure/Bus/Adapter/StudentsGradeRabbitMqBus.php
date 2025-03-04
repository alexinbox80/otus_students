<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\StudentsGradeBusInterface;
use App\Domain\DTO\StudentsGradeDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class StudentsGradeRabbitMqBus implements StudentsGradeBusInterface
{
    public function __construct(private readonly RabbitMqBus $rabbitMqBus)
    {
    }

    public function studentsGrade(StudentsGradeDTO $studentsGradeDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::StudentsGrade, $studentsGradeDTO);
    }
}
