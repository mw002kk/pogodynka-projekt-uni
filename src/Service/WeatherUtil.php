<?php
declare(strict_types=1);

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;

#[AllowDynamicProperties]
class WeatherUtil
{
    private ForecastRepository $forecastRepository;
    private LocationRepository $locationRepository;

    public function __construct(ForecastRepository $forecastRepository, LocationRepository $locationRepository)
    {
        $this->forecastRepository = $forecastRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->forecastRepository->findByLocation($location);
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {

        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city
        ]);

        if ($location === null) {
            return [];
        }

        return $this->forecastRepository->findByLocation($location);
    }
}
