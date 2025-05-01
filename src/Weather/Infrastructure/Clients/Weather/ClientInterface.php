<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\Clients\Weather;

interface ClientInterface
{
    /**
     * @return array{
     *      city: string,
     *      country: string,
     *      temperature: float,
     *      condition: string,
     *      humidity: int,
     *      wind_speed: float,
     *      last_updated: string,
     *  }
     *
     * @throws Exception
     *
     */
    public function current(string $city): array;
}