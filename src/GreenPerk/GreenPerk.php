<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\GreenPerk;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;

class GreenPerk
{
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class, array $params = null)
    {
        $result = new $class();
        if (is_null($params)) {
            $response = $this->travelPerk->{$method}($url);
        } else {
            $response = $this->travelPerk->{$method}($url, $params);
        }

        //TODO: This won't go here. Ugly fix!
        $response = str_replace([
            'CO2e_kg',
        ], [
            'co2e_kg',
        ], $response);
        //TODO

        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * Get emissions for flight.
     */
    public function flightEmissions(
        string $origin,
        string $destination,
        string $cabinClass,
        string $airlineCode
    ): Emissions {
        $params = new FlightEmissionsParams(
            $origin,
            $destination,
            $cabinClass,
            $airlineCode
        );

        return $this->execute(
            'get',
            implode('/', ['emissions', 'flight']).'?'.$params->asUrlParam(),
            Emissions::class
        );
    }

    /**
     * Get emissions for train.
     */
    public function trainEmissions(
        string $originId,
        string $destinationId,
        string $vendor = null
    ): Emissions {
        $params = new TrainEmissionsParams(
            $originId,
            $destinationId,
            $vendor
        );

        return $this->execute(
            'get',
            implode('/', ['emissions', 'train']).'?'.$params->asUrlParam(),
            Emissions::class
        );
    }

    /**
     * Get emissions for car.
     */
    public function carEmissions(
        string $acrissCode,
        int $numDays,
        int $distancePerDay = null
    ): Emissions {
        $params = new CarEmissionsParams(
            $acrissCode,
            $numDays,
            $distancePerDay
        );

        return $this->execute(
            'get',
            implode('/', ['emissions', 'car']).'?'.$params->asUrlParam(),
            Emissions::class
        );
    }

    /**
     * Get emissions for hotel.
     */
    public function hotelEmissions(
        string $countryCode,
        int $numNights
    ): Emissions {
        $params = new HotelEmissionsParams(
            $countryCode,
            $numNights
        );

        return $this->execute(
            'get',
            implode('/', ['emissions', 'hotel']).'?'.$params->asUrlParam(),
            Emissions::class
        );
    }
}
