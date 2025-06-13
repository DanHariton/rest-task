<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class RequestLoggerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $requestLogger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $recordId = Uuid::uuid4()->toString();
        $timestamp = new \DateTimeImmutable()->format(\DateTimeInterface::ATOM);

        $context = [
            'record_id'  => $recordId,
            'timestamp'  => $timestamp,
            'query'      => $request->query->all(),
            'body'       => $request->request->all(),
            'attributes' => $request->attributes->all(),
        ];

        $this->requestLogger->info('Incoming request', $context);
    }
}
