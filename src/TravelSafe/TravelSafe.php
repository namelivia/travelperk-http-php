<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\TravelSafe;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\TravelSafe\Restrictions\Restriction;
use Namelivia\TravelPerk\TravelSafe\Summary\Summary;
use Namelivia\TravelPerk\TravelSafe\AirlineMeasures\AirlineMeasure;

class TravelSafe
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
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * Provides information about the authorization status and requirements of travel from one location to another.
     */
    public function travelRestrictions(
        string $origin,
        string $destination,
        string $originType,
        string $destinationType,
        string $date
    ): Restriction
    {
        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'restriction']),
            Restriction::class,
            [
                'origin' => $origin,
                'destination' => $destination,
                'origin_type' => $originType,
                'destination_type' => $destinationType,
                'date' => $date,
            ]
        );
    }

    /**
     * Retrieve the local summary.
     */
    public function localSummary(string $locationType, string $location): Summary
    {
        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'guidelines']),
            Summary::class,
            [
                'location_type' => $locationType,
                'location' => $location,
            ]
        );
    }

    /**
     * Retrieve the local summary.
     */
    public function airlineSafetyMeasures(string $iata): AirlineMeasure
    {
        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'airline_safety_measures']),
            AirlineMeasure::class,
            ['iata_code' => $iata]
        );
    }
}
