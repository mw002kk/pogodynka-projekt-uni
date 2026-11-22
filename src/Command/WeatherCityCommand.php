<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
use function PHPUnit\Framework\isEmpty;

#[AsCommand(
    name: 'weather:city',
    description: 'Shows weather forecast for country code and city',
)]
class WeatherCityCommand{

    public function __construct(private WeatherUtil $weatherUtil)
    {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country code')] string $country,
        #[Argument('City name')] string $city,
    ): int {
        $forecasts = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if (empty($forecasts)) {
            $io->warning('No forecast for this city.');
            return Command::FAILURE;
        }

        $rows = [];
        $io->writeln(sprintf('Location: %s, %s', $city, $country));

        foreach ($forecasts as $forecast) {
            if ($forecast->getDate() === null) {
                return Command::FAILURE;
            }
            $rows[] = [
                $forecast->getDate()->format('Y-m-d'),
                $forecast->getTemperature(),
            ];
        }
        $io->table(['Data', 'Temperatura'], $rows);
        return Command::SUCCESS;
    }
}
