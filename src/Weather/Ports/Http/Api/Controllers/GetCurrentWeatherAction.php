<?php

declare(strict_types=1);

namespace App\Weather\Ports\Http\Api\Controllers;

use App\Weather\Application\Queries\CurrentWeatherQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class GetCurrentWeatherAction
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    #[Route(path: 'current', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $query = CurrentWeatherQuery::fromArray($request->query->all());

        return new JsonResponse([
            'data' => $this->handle($query),
        ]);
    }
}