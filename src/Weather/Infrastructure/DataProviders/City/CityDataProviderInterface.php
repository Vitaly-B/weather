<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\DataProviders\City;

interface CityDataProviderInterface
{
    /**
     * @return  CityDTO[]
     */
    public function getCities(): array;
}