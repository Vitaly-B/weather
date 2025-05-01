<?php

declare(strict_types=1);

namespace App\Weather\Ports\CLI;

use App\Weather\Infrastructure\Clients\Weather\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:weather:current',
    description: 'Show Current weather'
)]
final class CurrentWeather extends Command
{
    private const string CITY = 'city';

    public function __construct(private readonly ClientInterface $weatherClient)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp(
                'This command show current weather'
            )
            ->addArgument(
                self::CITY,
                InputArgument::REQUIRED,
                'City name',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $city = $input->getArgument(self::CITY);

            $weatherInfo = $this->weatherClient->current($city);

            $output->writeln("");

            $output->writeln("<info>City: {$weatherInfo['city']}</info>");
            $output->writeln("<info>Country: {$weatherInfo['country']}</info>");
            $output->writeln("<info>Temperature: {$weatherInfo['temperature']}</info>");
            $output->writeln("<info>Condition: {$weatherInfo['condition']}</info>");
            $output->writeln("<info>Humidity: {$weatherInfo['humidity']}</info>");
            $output->writeln("<info>Wind Speed: {$weatherInfo['wind_speed']}</info>");
            $output->writeln("<info>Last Updated: {$weatherInfo['last_updated']}</info>");

            $output->writeln("");
        } catch (\Throwable $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}