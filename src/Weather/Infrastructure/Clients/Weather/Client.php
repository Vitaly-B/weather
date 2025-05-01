<?php

declare(strict_types=1);

namespace App\Weather\Infrastructure\Clients\Weather;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class Client implements ClientInterface
{

    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }

    /**
     * @inheritDoc
     */
    public function current(string $city): array
    {
        try {
            $data = $this->httpClient->request('GET', 'current.json', [
                'query' => [
                    'q' => $city,
                ]
            ])->toArray();

            return [
                'city' => $data['location']['name'],
                'country' => $data['location']['country'],
                'temperature' => $data['current']['temp_c'],
                'condition' => $data['current']['condition']['text'],
                'humidity' => $data['current']['humidity'],
                'wind_speed' => $data['current']['wind_kph'],
                'last_updated' => $data['current']['last_updated'],
            ];
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}