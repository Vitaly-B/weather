<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\DataProviders\City;

final class CityDataProvider implements CityDataProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getCities(): array
    {
        return [
            new CityDTO(name: 'Kyiv'),
            new CityDTO(name: 'Odesa'),
            new CityDTO(name: 'Lviv'),
            new CityDTO(name: 'Kharkiv'),
            new CityDTO(name: 'Lutsk'),
        ];
    }
}