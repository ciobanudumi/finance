<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\NoSendEmailException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws \JsonException
     */
    final public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new Response();

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() >= 400 && $exception->getStatusCode() < 500) {
            $content = [];

            $content['message'] = sprintf(
                'Error: %s , with message error: %s',
                $exception->getStatusCode(),
                $exception->getMessage()
            );
            $this->logger->warning($content['message']);
            $content['code'] = $exception->getStatusCode();
            $contentEncode = json_encode($content, JSON_THROW_ON_ERROR);
            $response->setContent($contentEncode);
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->set('Content-Type', 'application/json', true);
            $event->setResponse($response);
        }

        if ($exception instanceof NoSendEmailException) {
            $content = [];

            if ($exception->getCode() > 0 && $exception->getCode() <= 500) {
                $code = $exception->getCode();
            } else {
                $code = 500;
            }

            $content['message'] = sprintf(
                '%s',
                $exception->getMessage()
            );
            $this->logger->warning($content['message']);
            $content['code'] = $code;
            $contentEncode = json_encode($content, JSON_THROW_ON_ERROR);
            $response->setContent($contentEncode);
            $response->setStatusCode($code);
            $response->headers->set('Content-Type', 'application/json', true);
            $event->setResponse($response);
        }
    }
}
