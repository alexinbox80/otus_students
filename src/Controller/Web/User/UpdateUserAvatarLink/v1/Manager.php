<?php

namespace App\Controller\Web\User\UpdateUserAvatarLink\v1;

use App\Controller\Web\User\UpdateUserAvatarLink\v1\Output\UpdatedUserAvatarDTO;
use App\Domain\Entity\User;
use App\Domain\Service\FileService;
use App\Domain\Service\UserService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Manager
{
    public function __construct(
        private readonly FileService $fileService,
        private readonly UserService $userService,
        private readonly string $baseUrl,
        private readonly string $uploadPrefix,
    ) {
    }

    public function updateUserAvatarLink(User $user, UploadedFile $uploadedFile): UpdatedUserAvatarDTO
    {
        $file = $this->fileService->storeUploadedFile($uploadedFile);
        $path = $this->baseUrl . str_replace($this->uploadPrefix, '', $file->getRealPath());
        $this->userService->updateAvatarLink($user, $path);

        return new UpdatedUserAvatarDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getAvatarLink(),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $user->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
