<?php

declare(strict_types=1);

namespace App\Weather\Ports\Http\Api\Resources;

use App\Shared\Lib\Assertion\Assert;
use DateTime;
use JsonSerializable;

final readonly class CurrentWeatherResource implements JsonSerializable
{
    private const string CITY = 'city';
    private const string COUNTRY = 'country';
    private const string TEMPERATURE = 'temperature';
    private const string CONDITION = 'condition';
    private const string HUMIDITY = 'humidity';
    private const string WIND_SPEED = 'wind_speed';
    private const string LAST_UPDATE = 'last_updated';

    public function __construct(
        public string $city,
        public string $country,
        public float $temperature,
        public string $condition,
        public int $humidity,
        public float $windSpeed,
        public DateTime $lastUpdated
    ) {
    }

    public static function fromArray(array $data): self
    {
        Assert::keyExists(
            $data,
            self::CITY,
            'Given data does not contains `' . self::CITY . '` key'
        );
        Assert::keyExists(
            $data,
            self::COUNTRY,
            'Given data does not contains `' . self::COUNTRY . '` key'
        );
        Assert::keyExists(
            $data,
            self::TEMPERATURE,
            'Given data does not contains `' . self::TEMPERATURE . '` key'
        );
        Assert::keyExists(
            $data,
            self::CONDITION,
            'Given data does not contains `' . self::CONDITION . '` key'
        );
        Assert::keyExists(
            $data,
            self::HUMIDITY,
            'Given data does not contains `' . self::HUMIDITY . '` key'
        );
        Assert::keyExists(
            $data,
            self::WIND_SPEED,
            'Given data does not contains `' . self::WIND_SPEED . '` key'
        );
        Assert::keyExists(
            $data,
            self::LAST_UPDATE,
            'Given data does not contains `' . self::LAST_UPDATE . '` key'
        );

        return new self(
            city: $data[self::CITY],
            country: $data[self::COUNTRY],
            temperature: $data[self::TEMPERATURE],
            condition: $data[self::CONDITION],
            humidity: $data[self::HUMIDITY],
            windSpeed: $data[self::WIND_SPEED],
            lastUpdated: DateTime::createFromFormat('Y-m-d H:i', $data[self::LAST_UPDATE]),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            self::CITY => $this->city,
            self::COUNTRY => $this->country,
            self::TEMPERATURE => $this->temperature,
            self::CONDITION => $this->condition,
            self::HUMIDITY => $this->humidity,
            self::WIND_SPEED => $this->windSpeed,
            self::LAST_UPDATE => $this->lastUpdated,
        ];
    }
}