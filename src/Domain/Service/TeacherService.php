<?php

namespace App\Domain\Service;

use App\Domain\Entity\Person;
use App\Domain\Entity\Teacher;
use App\Domain\Model\CreateEmailConfirmationCodeModel;
use App\Domain\Model\CreatePhoneConfirmationCodeModel;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Model\TeacherModel;
use App\Domain\Model\UpdateTeacherModel;
use App\Domain\Repository\TeacherRepositoryInterface;
use Psr\Cache\InvalidArgumentException;

class TeacherService
{
    public function __construct(
        private readonly TeacherRepositoryInterface $teacherRepository,
        private readonly UserService $userService
    ) {
    }

    /**
     * @param CreateEmailConfirmationCodeModel $emailConfirmationCodeModel
     * @param string $login
     * @return bool
     * @throws InvalidArgumentException
     */
    public function confirmationEmail(CreateEmailConfirmationCodeModel $emailConfirmationCodeModel, string $login): bool
    {
        $user = $this->userService->findUserByLogin($login);
        if($user->getTeacher()->getEmailCode() !== $emailConfirmationCodeModel->emailCode)
            return false;
        else {
            $user->getTeacher()->setEmailConfirmed(true);
            $this->teacherRepository->update();
        }

        return true;
    }

    /**
     * @param CreatePhoneConfirmationCodeModel $phoneConfirmationCodeModel
     * @param string $login
     * @return bool
     * @throws InvalidArgumentException
     */
    public function confirmationPhone(CreatePhoneConfirmationCodeModel $phoneConfirmationCodeModel, string $login): bool
    {
        $user = $this->userService->findUserByLogin($login);
        if($user->getTeacher()->getPhoneCode() !== $phoneConfirmationCodeModel->phoneCode)
            return false;
        else {
            $user->getTeacher()->setPhoneConfirmed(true);
            $this->teacherRepository->update();
        }

        return true;
    }

    /**
     * @param int $teacherId
     * @return ?TeacherModel
     */
    public function find(int $teacherId): ?TeacherModel
    {
        return $this->teacherRepository->find($teacherId);
    }

    /**
     * @return TeacherModel[]
     */
    public function findAll(): array
    {
        return $this->teacherRepository->findAll();
    }

    /**
     * @param string $lastName
     * @return TeacherModel[]
     */
    public function findTeachersByLastName(string $lastName): array
    {
        return $this->teacherRepository->findTeachersByLastName($lastName);
    }

    /**
     * @param string $firstName
     * @return TeacherModel[]
     */
    public function findTeachersByFirstName(string $firstName): array
    {
        return $this->teacherRepository->findTeachersByFirstName($firstName);
    }

    /**
     * @param string $middleName
     * @return TeacherModel[]
     */
    public function findTeachersByMiddleName(string $middleName): array
    {
        return $this->teacherRepository->findTeachersByMiddleName($middleName);
    }

    /**
     * @return TeacherModel[]
     * @throws InvalidArgumentException
     */
    public function getTeachersPaginated(int $page, int $perPage): array
    {
        return $this->teacherRepository->getTeachersPaginated($page, $perPage);
    }

    /**
     * @param int $teacherId
     * @param Person $person
     * @return TeacherModel|null
     * @throws InvalidArgumentException
     */
    public function updateName(int $teacherId, Person $person): ?TeacherModel
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if (!($teacher instanceof Teacher)) {
            return null;
        }
        $this->teacherRepository->updateName($teacher, $person);

        return $teacher;
    }

    /**
     * @param int $teacherId
     * @param Person $person
     * @return TeacherModel|null
     * @throws InvalidArgumentException
     */
    public function updateContact(int $teacherId, Person $person): ?TeacherModel
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if (!($teacher instanceof Teacher)) {
            return null;
        }
        $this->teacherRepository->updateContact($teacher, $person);

        return $teacher;
    }

    /**
     * @param CreateTeacherModel $createTeacherModel
     * @return TeacherModel
     * @throws InvalidArgumentException
     */
    public function create(CreateTeacherModel $createTeacherModel): TeacherModel
    {
        $user = $this->userService->find($createTeacherModel->userId);

        $teacher = new Teacher(
            $user,
            $createTeacherModel->firstName,
            $createTeacherModel->lastName,
            $createTeacherModel->middleName,
            $createTeacherModel->email,
            $createTeacherModel->phone
        );
        $teacher->setEmailCode($createTeacherModel->emailCode);
        $teacher->setPhoneCode($createTeacherModel->phoneCode);

        $this->teacherRepository->create($teacher);

        return new TeacherModel(
            $teacher->getId(),
            $teacher->getUser()->getId(),
            $teacher->getFirstName(),
            $teacher->getLastName(),
            $teacher->getMiddleName(),
            $teacher->getEmail(),
            $teacher->getPhone(),
            $teacher->getCreatedAt(),
            $teacher->getUpdatedAt()
        );
    }

    /**
     * @param Teacher $teacher
     * @param UpdateTeacherModel $updateTeacherModel
     * @return TeacherModel
     * @throws InvalidArgumentException
     */
    public function update(Teacher $teacher, UpdateTeacherModel $updateTeacherModel): TeacherModel
    {
        $user = $this->userService->find($updateTeacherModel->userId);

        $teacher->changeFields(
            $user,
            $updateTeacherModel->firstName,
            $updateTeacherModel->lastName,
            $updateTeacherModel->middleName,
            $updateTeacherModel->email,
            $updateTeacherModel->phone
        );

        $this->teacherRepository->update();

        return new TeacherModel(
            $teacher->getId(),
            $teacher->getUser()->getId(),
            $teacher->getFirstName(),
            $teacher->getLastName(),
            $teacher->getMiddleName(),
            $teacher->getEmail(),
            $teacher->getPhone(),
            $teacher->getCreatedAt(),
            $teacher->getUpdatedAt()
        );
    }

    /**
     * @param int $teacherId
     * @return void
     * @throws InvalidArgumentException
     */
    public function removeById(int $teacherId): void
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if ($teacher !== null) {
            $this->teacherRepository->remove($teacher);
        }
    }

    /**
     * @param Teacher $teacher
     * @return void
     * @throws InvalidArgumentException
     */
    public function removeTeacher(Teacher $teacher): void
    {
        $this->teacherRepository->remove($teacher);
    }
}
