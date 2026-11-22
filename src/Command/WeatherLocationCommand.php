<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Shows weather forecast for location by ID',
)]
class WeatherLocationCommand{


    public function __construct(
        private LocationRepository $locationRepository,
        private WeatherUtil $weatherUtil,
    ) {}

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {

        $location = $this->locationRepository->find($id);
        if (null === $location) {
            $io->error(sprintf('Location %d not found', $id));
            return Command::FAILURE;
        }
        $locationWeather = $this->weatherUtil->getWeatherForLocation($location);

        $rows = [];
        $io->writeln(sprintf('Location: %s', $location->getCity()));
        foreach ($locationWeather as $forecast) {
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
