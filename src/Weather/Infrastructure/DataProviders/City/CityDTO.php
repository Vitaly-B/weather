<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\DataProviders\City;

use App\Shared\Lib\Assertion\Assert;

final readonly class CityDTO
{
    public function __construct(public string $name)
    {
        Assert::notEmpty($this->name);
    }
}