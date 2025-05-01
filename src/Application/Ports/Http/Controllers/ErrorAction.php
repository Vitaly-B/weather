<?php

declare(strict_types=1);

namespace App\Application\Ports\Http\Controllers;

use App\Shared\Domain\Exceptions\InvalidArgumentException;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ErrorAction extends ErrorController
{
    public function __construct(
        private readonly KernelInterface $kernel,
        string|object|array|null $controller,
        ErrorRendererInterface $errorRenderer,
        private readonly RequestStack $requestStack,
    ) {
        parent::__construct($this->kernel, $controller, $errorRenderer);
    }

    public function __invoke(\Throwable $exception): Response
    {
        $request = $this->requestStack->getMainRequest();

        $uri = $request->getRequestUri();

        if (stripos($uri, '/api') === 0) {
            return $this->forApi($exception);
        }

        return parent::__invoke($exception);
    }

    private function forApi(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof HandlerFailedException && !is_null($exception->getPrevious())) {
            $exception = $exception->getPrevious();
        }

        $content = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($this->kernel->getEnvironment() !== 'prod') {
            $content += [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];
        }

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        $headers = [];

        \ksort($content);


        if ($exception instanceof InvalidArgumentException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $headers = $exception->getHeaders();
        }

        return new JsonResponse($content, $statusCode, $headers);
    }
}