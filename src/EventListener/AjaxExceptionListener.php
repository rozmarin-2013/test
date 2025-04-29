<?php

namespace App\EventListener;

use App\Attributes\Ajax;
use App\Response\AjaxResponse;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AjaxExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {

        $request = $event->getRequest();
        $controller = $request->attributes->get('_controller');

        if (!$controller) {
            return;
        }

        list($controllerClass, $method) = explode('::', $controller);

        $reflectionClass = new ReflectionClass($controllerClass);
        if (!$reflectionClass->getAttributes(Ajax::class)) {
            return;
        }

        $exception = $event->getThrowable();
        $message = sprintf(
            'Error : %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $response = new AjaxResponse(false,  ['message' => $message], $code);

        $event->setResponse($response);
    }
}