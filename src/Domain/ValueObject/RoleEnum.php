<?php

namespace App\Domain\ValueObject;

//Создана следующая RBAC-модель:
enum RoleEnum: string
{
    //Дефолтная роль для всех пользователей
    case ROLE_USER = 'ROLE_USER';

    //Студент (ROLE_STUDENT) – чтение заданий и занятий
    case ROLE_STUDENT = 'ROLE_STUDENT';

    //Преподаватель (ROLE_TEACHER) – полный доступ занятия, задания. Студенты и группы на чтение
    case ROLE_TEACHER = 'ROLE_TEACHER';

    //Менеджер (ROLE_MANAGER) – чтение занятия и задания. Полный доступ студенты и группы, сброс фиксации занятий
    case ROLE_MANAGER = 'ROLE_MANAGER';
}
