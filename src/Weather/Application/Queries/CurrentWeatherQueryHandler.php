<?php

declare(strict_types=1);

namespace App\Weather\Application\Queries;

use App\Weather\Infrastructure\Clients\Weather\ClientInterface;
use App\Weather\Infrastructure\Clients\Weather\Exception;
use App\Weather\Ports\Http\Api\Resources\CurrentWeatherResource;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class CurrentWeatherQueryHandler
{
    public function __construct(private ClientInterface $weatherClient)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CurrentWeatherQuery $query): CurrentWeatherResource
    {
        return CurrentWeatherResource::fromArray($this->weatherClient->current($query->city));
    }
}