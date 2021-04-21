<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Api\Infrastructure\ApiPlatform;

use Negotiation\AcceptLanguage;
use Negotiation\LanguageNegotiator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AcceptLanguageEventListener implements EventSubscriberInterface
{
    private array $supportedLanguages;

    public function __construct(array $supportedLanguages = [])
    {
        $this->supportedLanguages = $supportedLanguages;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 200]],
            KernelEvents::RESPONSE => [['onKernelResponse', 200]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->headers->has('Accept-Language')) {
            return;
        }

        $negotiator = new LanguageNegotiator();

        /** @var AcceptLanguage|null $bestLocale */
        $bestLocale = $negotiator->getBest((string) $request->headers->get('Accept-Language'), $this->supportedLanguages);

        if ($bestLocale !== null) {
            $request->setLocale($bestLocale->getBasePart());
        }
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('Content-Language', $event->getRequest()->getLocale());
    }
}
