<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\TravelSafe;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\TravelSafe\AirlineMeasures\AirlineMeasure;
use Namelivia\TravelPerk\TravelSafe\Restrictions\Restriction;
use Namelivia\TravelPerk\TravelSafe\Summary\Summary;

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
        Carbon $date
    ): Restriction {
        $params = new TravelRestrictionParams(
            $origin,
            $destination,
            $originType,
            $destinationType,
            $date
        );

        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'restrictions']).'?'.$params->asUrlParam(),
            Restriction::class
        );
    }

    /**
     * Retrieve the local summary.
     */
    public function localSummary(string $location, string $locationType): Summary
    {
        $params = new LocalSummaryParams(
            $location,
            $locationType
        );

        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'guidelines']).'?'.$params->asUrlParam(),
            Summary::class
        );
    }

    /**
     * Retrieve airline safety measures.
     */
    public function airlineSafetyMeasures(string $iata): AirlineMeasure
    {
        return $this->execute(
            'get',
            implode('/', ['travelsafe', 'airline_safety_measures']).'?iata_code='.$iata,
            AirlineMeasure::class
        );
    }

    /**
     * Get all location types.
     */
    public function locationTypes(): array
    {
        return LocationType::getConstantValues();
    }
}
