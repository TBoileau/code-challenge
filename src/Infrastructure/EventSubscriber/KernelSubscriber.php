<?php

namespace App\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;
use TBoileau\CodeChallenge\Domain\System\Request\TrackRequest;

/**
 * Class KernelSubscriber
 * @package App\Infrastructure\EventSubscriber
 */
class KernelSubscriber implements EventSubscriberInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * KernelSubscriber constructor.
     * @param MessageBusInterface $messageBus
     * @param Security $security
     */
    public function __construct(MessageBusInterface $messageBus, Security $security)
    {
        $this->messageBus = $messageBus;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => "onRequest"
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onRequest(RequestEvent $event): void
    {
        if (
            !$event->isMasterRequest()
            || $event->getRequest()->attributes->get("_route") === null
            || $event->getRequest()->attributes->get("_route") === "_wdt"
            || $event->getRequest()->attributes->get("_route") === "_profiler"
        ) {
            return;
        }

        $trackRequest = new TrackRequest(
            $event->getRequest()->getMethod(),
            $event->getRequest()->attributes->get("_route"),
            $event->getRequest()->attributes->get("_route_params", []),
            $event->getRequest()->request->all(),
            $event->getRequest()->query->all(),
            $event->getRequest()->getClientIp(),
            $this->security->isGranted("ROLE_USER") ? $this->security->getUser()->getUsername() : null
        );

        $this->messageBus->dispatch($trackRequest);
    }
}
