<?php

namespace App\Application\EventListener;

use App\Controller\DTO\Interfaces\OutputDTOInterface;
use App\Controller\DTO\Interfaces\OutputDTONotFoundInterface;
use App\Controller\DTO\Interfaces\OutputEmailCodeConfirmedDTOInterface;
use App\Controller\DTO\Interfaces\OutputPhoneCodeConfirmedDTOInterface;
use App\Controller\DTO\Interfaces\OutputSalesGeneratedPaymentLinkDTOInterface;
use App\Controller\DTO\Interfaces\OutputSalesIsCustomerDTOInterface;
use App\Controller\DTO\Interfaces\OutputSalesIsProductDTOInterface;
use App\Controller\DTO\Interfaces\OutputSalesSubscribedDTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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

        if (is_object($dto) and $dto instanceof OutputSalesGeneratedPaymentLinkDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputSalesSubscribedDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputSalesIsCustomerDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputSalesIsProductDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputEmailCodeConfirmedDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputPhoneCodeConfirmedDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputDTOInterface) {
            $event->setResponse($this->getDTOResponse($dto, Response::HTTP_OK));
        }

        if (is_object($dto) and $dto instanceof OutputDTONotFoundInterface) {
            $event->setResponse($this->getDTOResponse([
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND));
        }

        if (is_array($dto) and array_key_exists('token', $dto)) {
            $event->setResponse($this->getDTOResponse([
                'token' => $dto['token'],
                'success' => true,
                'code' => Response::HTTP_OK
            ], Response::HTTP_OK));
        } elseif (is_array($dto)) {
            if (isset($dto['skills'])
                || isset($dto['completed-tasks'])
                || isset($dto['students'])
                || isset($dto['teachers'])
                || isset($dto['grade-for-course'])
                || isset($dto['grade-for-lesson'])
                || isset($dto['grade-for-lesson-in-time-range'])
                || isset($dto['grade-for-skill'])
            ) {
                $successResponse = $dto;
            } else {
                $successResponse = [];
                foreach ($dto as $item) {
                    $successResponse[] = $item->toArray();
                }
            }

            if(count($successResponse) > 0)
                $event->setResponse($this->getDTOResponse($successResponse, Response::HTTP_OK));
            else
                $event->setResponse($this->getDTOResponse([
                    'success' => false,
                    'code' => Response::HTTP_NOT_FOUND
                ], Response::HTTP_NOT_FOUND));
        }
    }

    private function getDTOResponse($data, int $code): Response
    {
        $serializedData = $this->serializer->serialize(
            $data,
            'json',
            [
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['active']
            ]
        );

        return new JsonResponse($serializedData, $code, [], true);
    }
}
