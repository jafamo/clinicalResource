<?php
//
//namespace App\Infrastructure\EventListener;
//
//use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpKernel\Event\ExceptionEvent;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\HttpKernel\KernelEvents;
//use Symfony\Component\Routing\RouterInterface;
//
//class NotFoundListener implements EventSubscriberInterface
//{
//    private RouterInterface $router;
//
//    public function __construct(RouterInterface $router)
//    {
//        $this->router = $router;
//    }
//
//    public static function getSubscribedEvents(): array
//    {
//        return [
//            // the priority must be greater than the Security HTTP
//            // ExceptionListener, to make sure it's called before
//            // the default exception listener
//            KernelEvents::EXCEPTION => ['onKernelException', 2],
//        ];
//    }
//
//    public function onKernelException(ExceptionEvent $event): void
//    {
//        $exception = $event->getThrowable();
//
//        if ($exception instanceof NotFoundHttpException) {
//            $response = new RedirectResponse($this->router->generate('error_page', ['code' => 404]));
//            $event->setResponse($response);
//        }
//    }
//}