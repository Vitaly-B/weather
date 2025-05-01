<?php

declare(strict_types=1);

namespace App\Tests\Unit\Weather\Infrastructure\DataProviders\City;

use App\Weather\Infrastructure\DataProviders\City\CityDataProvider;
use App\Weather\Infrastructure\DataProviders\City\CityDataProviderInterface;
use App\Weather\Infrastructure\DataProviders\City\CityDTO;
use PHPUnit\Framework\TestCase;

final class CityDataProviderTest extends TestCase
{
    public function test_object_creation(): CityDataProvider
    {
        $dataProvider = new CityDataProvider();

        self::assertInstanceOf(CityDataProviderInterface::class, $dataProvider);

        return $dataProvider;
    }

    /**
     * @depends test_object_creation
     */
    public function test_get_cities(CityDataProviderInterface $cityDataProvider): void
    {
        foreach ($cityDataProvider->getCities() as $city) {
            self::assertInstanceOf(CityDTO::class, $city);
            self::assertObjectHasProperty('name', $city);
            self::assertNotEmpty($city->name);
        }
    }
}