<?php

declare(strict_types=1);

namespace App\Weather\Application\Queries;

use App\Shared\Lib\Assertion\Assert;

final readonly class CurrentWeatherQuery
{
    private const string CITY = 'city';

    public function __construct(public string $city)
    {
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists(
            $data,
            self::CITY,
            'Given data does not contains `' . self::CITY . '` key'
        );

        return new self(
            $data[self::CITY],
        );
    }
}