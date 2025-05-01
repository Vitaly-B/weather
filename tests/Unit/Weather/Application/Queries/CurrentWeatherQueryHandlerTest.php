<?php

declare(strict_types=1);

namespace App\Tests\Unit\Weather\Application\Queries;

use App\Weather\Application\Queries\CurrentWeatherQuery;
use App\Weather\Application\Queries\CurrentWeatherQueryHandler;
use App\Weather\Infrastructure\Clients\Weather\ClientInterface;
use App\Weather\Infrastructure\Clients\Weather\Exception;
use App\Weather\Ports\Http\Api\Resources\CurrentWeatherResource;
use PHPUnit\Framework\TestCase;

final class CurrentWeatherQueryHandlerTest extends TestCase
{
    private const string CITY_NAME = 'City_test';
    private const string COUNTRY_NAME = 'Country_test';

    /**
     * @throws Exception
     */
    public function test_handle(): void
    {
        $weatherData = [
            'city' => self::CITY_NAME,
            'country' => self::COUNTRY_NAME,
            'temperature' => 1.3,
            'condition' => 'Clear',
            'humidity' => 61,
            'wind_speed' => 3.6,
            'last_updated' => '2025-05-01 23:45',
        ];

        $weatherClient = $this->createMock(ClientInterface::class);

        $weatherClient->expects(self::once())->method('current')
            ->with(self::CITY_NAME)
            ->willReturn($weatherData);

        $query = new CurrentWeatherQuery(city: self::CITY_NAME);
        $resource = (new CurrentWeatherQueryHandler(weatherClient: $weatherClient))(query: $query);

        self::assertInstanceOf(CurrentWeatherResource::class, $resource);

        self::assertEquals(self::CITY_NAME, $resource->city);
        self::assertEquals(self::COUNTRY_NAME, $resource->country);
        self::assertEquals($weatherData['temperature'], $resource->temperature);
        self::assertEquals($weatherData['condition'], $resource->condition);
        self::assertEquals($weatherData['humidity'], $resource->humidity);
        self::assertEquals($weatherData['wind_speed'], $resource->windSpeed);
        self::assertEquals($weatherData['last_updated'], $resource->lastUpdated->format('Y-m-d H:i'));
    }
}