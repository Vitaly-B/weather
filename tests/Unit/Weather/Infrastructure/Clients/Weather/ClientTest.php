<?php

declare(strict_types=1);

namespace App\Tests\Unit\Weather\Infrastructure\Clients\Weather;

use App\Weather\Infrastructure\Clients\Weather\Client;
use App\Weather\Infrastructure\Clients\Weather\ClientInterface;
use App\Weather\Infrastructure\Clients\Weather\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

final class ClientTest extends TestCase
{
    private const string CITY = 'City_test';

    private const array SUCCESS_RESPONSE = [
        "location" => [
            "name" => self::CITY,
            "region" => "Test Oblast'",
            "country" => "Ukraine",
            "lat" => 50.75,
            "lon" => 25.3333,
            "tz_id" => "Europe/Kiev",
            "localtime_epoch" => 1746132665,
            "localtime" => "2025-05-01 23:51"
        ],
        "current" => [
            "last_updated_epoch" => 1746132300,
            "last_updated" => "2025-05-01 23:45",
            "temp_c" => 7.7,
            "temp_f" => 45.8,
            "is_day" => 0,
            "condition" => [
                "text" => "Clear",
                "icon" => "//cdn.weatherapi.com/weather/64x64/night/113.png",
                "code" => 1000
            ],
            "wind_mph" => 3.4,
            "wind_kph" => 5.4,
            "wind_degree" => 54,
            "wind_dir" => "NE",
            "pressure_mb" => 1023.0,
            "pressure_in" => 30.21,
            "precip_mm" => 0.0,
            "precip_in" => 0.0,
            "humidity" => 58,
            "cloud" => 9,
            "feelslike_c" => 7.0,
            "feelslike_f" => 44.6,
            "windchill_c" => 7.0,
            "windchill_f" => 44.6,
            "heatindex_c" => 7.7,
            "heatindex_f" => 45.8,
            "dewpoint_c" => -0.1,
            "dewpoint_f" => 31.8,
            "vis_km" => 10.0,
            "vis_miles" => 6.0,
            "uv" => 0.0,
            "gust_mph" => 7.0,
            "gust_kph" => 11.3
        ]
    ];

    public function test_current(): void
    {
        $responseBody = json_encode(self::SUCCESS_RESPONSE);

        $mockResponse = new MockResponse($responseBody);
        $mockHttpClient = new MockHttpClient($mockResponse);

        $client = new Client(httpClient: $mockHttpClient);

        self::assertInstanceOf(ClientInterface::class, $client);

        $weatherInfo = $client->current(self::CITY);

        self::assertEquals(self::SUCCESS_RESPONSE['location']['name'], $weatherInfo['city']);
        self::assertEquals(self::SUCCESS_RESPONSE['location']['country'], $weatherInfo['country']);
        self::assertEquals(self::SUCCESS_RESPONSE['current']['temp_c'], $weatherInfo['temperature']);
        self::assertEquals(self::SUCCESS_RESPONSE['current']['condition']['text'], $weatherInfo['condition']);
        self::assertEquals(self::SUCCESS_RESPONSE['current']['humidity'], $weatherInfo['humidity']);
        self::assertEquals(self::SUCCESS_RESPONSE['current']['wind_kph'], $weatherInfo['wind_speed']);
        self::assertEquals(self::SUCCESS_RESPONSE['current']['last_updated'], $weatherInfo['last_updated']);
    }

    public function test_current_with_exception(): void
    {
        $errorCode = 500;

        $mockResponse = new MockResponse('Something with wrong', ['http_code' => $errorCode]);
        $mockHttpClient = new MockHttpClient($mockResponse);

        $client = new Client(httpClient: $mockHttpClient);

        self::assertInstanceOf(ClientInterface::class, $client);
        self::expectException(Exception::class);
        self::expectExceptionCode($errorCode);

        $client->current(self::CITY);
    }
}