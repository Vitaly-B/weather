<?php

declare(strict_types=1);

namespace App\Tests\Unit\Weather\Application\Queries;

use App\Shared\Domain\Exceptions\InvalidArgumentException;
use App\Weather\Application\Queries\CurrentWeatherQuery;
use PHPUnit\Framework\TestCase;

final class CurrentWeatherQueryTest extends TestCase
{
    private const string TEST_CITY_NAME = 'City_test';

    public function test_object_creation(): void
    {
        $query = new CurrentWeatherQuery(city: self::TEST_CITY_NAME);

        self::assertEquals(self::TEST_CITY_NAME, $query->city);
    }

    public function test_creation_from_array(): void
    {
        $data = ['city' => self::TEST_CITY_NAME];

        $query = CurrentWeatherQuery::fromArray($data);

        self::assertEquals(self::TEST_CITY_NAME, $query->city);
    }

    public function test_creation_from_array_without_data(): void
    {
        self::expectException(InvalidArgumentException::class);

        CurrentWeatherQuery::fromArray([]);
    }
}