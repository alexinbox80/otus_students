<?php

namespace App\Application\EventListener;

use App\Controller\DTO\Interfaces\OutputDTOInterface;
use App\Controller\DTO\Interfaces\OutputDTONotFoundInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class KernelViewEventListener
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $dto = $event->getControllerResult();

        if ($dto instanceof OutputDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if ($dto instanceof OutputDTONotFoundInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_NOT_FOUND));
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
