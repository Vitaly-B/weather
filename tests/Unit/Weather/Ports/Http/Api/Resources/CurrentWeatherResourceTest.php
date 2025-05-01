<?php

declare(strict_types=1);

namespace App\Tests\Unit\Weather\Ports\Http\Api\Resources;

use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Weather\Ports\Http\Api\Resources\CurrentWeatherResource;
use PHPUnit\Framework\TestCase;

final class CurrentWeatherResourceTest extends TestCase
{
    private const array DATA = [
        'city' => 'City_test',
        'country' => 'Country_test',
        'temperature' => 1.3,
        'condition' => 'Clear',
        'humidity' => 61,
        'wind_speed' => 3.6,
        'last_updated' => '2025-05-01 23:45',
    ];

    public function test_object_creation_from_array(): void
    {
        $resource = CurrentWeatherResource::fromArray(self::DATA);

        self::assertEquals(self::DATA['city'], $resource->city);
        self::assertEquals(self::DATA['country'], $resource->country);
        self::assertEquals(self::DATA['temperature'], $resource->temperature);
        self::assertEquals(self::DATA['condition'], $resource->condition);
        self::assertEquals(self::DATA['humidity'], $resource->humidity);
        self::assertEquals(self::DATA['wind_speed'], $resource->windSpeed);
        self::assertEquals(self::DATA['last_updated'], $resource->lastUpdated->format('Y-m-d H:i'));
    }

    /**
     * @dataProvider wrongDataProvider
     */
    public function test_object_creation_from_array_with_wrong_data(array $data, string $message): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($message);

        CurrentWeatherResource::fromArray($data);
    }

    public static function wrongDataProvider(): \Generator
    {
        yield 'Without city' => [
            'data' => array_diff_key(self::DATA, array_flip(['city'])),
            'Message' => 'Given data does not contains `city` key'
        ];
        yield 'Without country' => [
            'data' => array_diff_key(self::DATA, array_flip(['country'])),
            'Message' => 'Given data does not contains `country` key'
        ];
        yield 'Without temperature' => [
            'data' => array_diff_key(self::DATA, array_flip(['temperature'])),
            'Message' => 'Given data does not contains `temperature` key'
        ];
        yield 'Without condition' => [
            'data' => array_diff_key(self::DATA, array_flip(['condition'])),
            'Message' => 'Given data does not contains `condition` key'
        ];
        yield 'Without humidity' => [
            'data' => array_diff_key(self::DATA, array_flip(['humidity'])),
            'Message' => 'Given data does not contains `humidity` key'
        ];
        yield 'Without wind_speed' => [
            'data' => array_diff_key(self::DATA, array_flip(['wind_speed'])),
            'Message' => 'Given data does not contains `wind_speed` key'
        ];
        yield 'Without last_updated' => [
            'data' => array_diff_key(self::DATA, array_flip(['last_updated'])),
            'Message' => 'Given data does not contains `last_updated` key'
        ];
        yield 'Without any' => [
            'data' => [],
            'Message' => 'Given data does not contains `city` key'
        ];
    }
}