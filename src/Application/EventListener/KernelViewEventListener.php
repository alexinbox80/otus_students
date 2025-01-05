<?php

namespace App\Application\EventListener;

use App\Controller\DTO\Interfaces\OutputDTOInterface;
use App\Controller\DTO\Interfaces\OutputDTONotFoundInterface;
use App\Controller\DTO\User\GotUserDTO;
use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class KernelViewEventListener
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $dto = $event->getControllerResult();

        if (is_object($dto) and $dto instanceof OutputDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputDTONotFoundInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_NOT_FOUND));
        }

        if (is_array($dto)) {
            $successResponse = [];
            foreach ($dto as $item) {
                if ($item instanceof User)
                    $successResponse[] = new GotUserDTO(
                        $item->getId(),
                        $item->getLogin(),
                        $item->getRoles(),
                        $item->isActive(),
                        $item->getAvatarLink(),
                        $item->getCreatedAt(),
                        $item->getUpdatedAt()
                    );
            }

            if(count($successResponse) > 0)
                $event->setResponse($this->getDTOResponse($successResponse, Response::HTTP_OK));
            else
                $event->setResponse($this->getDTOResponse($successResponse, Response::HTTP_NOT_FOUND));
        }
    }

    private function getDTOResponse($data, int $code): Response
    {
        $serializedData = $this->serializer->serialize(
            $data,
            'json',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );

        return new JsonResponse($serializedData, $code, [], true);
    }
}
