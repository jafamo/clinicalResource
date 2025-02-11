<?php

namespace App\Infrastructure\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

class AccessDeniedListener implements EventSubscriberInterface
{

    public function __construct(private RouterInterface $router)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof AccessDeniedException) {
            return;
            $event->setResponse (new RedirectResponse($this->router->generate('error_page', ['code' => 403])));
        }
        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse (new RedirectResponse($this->router->generate('error_page', ['code' => 404])));
        }
        if ($exception->getCode() === 500) {
            $event->setResponse (new RedirectResponse($this->router->generate('error_page', ['code' => 500])));
        }

        // ... perform some action (e.g. logging)

        // optionally set the custom response


        // or stop propagation (prevents the next exception listeners from being called)
        //$event->stopPropagation();
    }


}
