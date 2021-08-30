<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Carbon\Carbon;
use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\TravelSafe\Summary\Summary;
use Namelivia\TravelPerk\TravelSafe\TravelSafe;

class TravelSafeTest extends TestCase
{
    private $travelPerk;
    private $travelsef;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->travelSafe = new TravelSafe($this->travelPerk, $this->mapper);
    }

    public function testGettingTravelRestrictions()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with(
                'travelsafe/restrictions?'.
                'origin=ES&destination=FR&origin_type=country_code&destination_type=country_code&date=2019-03-21'
            )
            ->andReturn(file_get_contents('tests/stubs/restriction.json'));
        $restriction = $this->travelSafe->travelRestrictions(
            'ES',
            'FR',
            'country_code',
            'country_code',
            Carbon::today()
        );
        $this->assertEquals('e7975c43-b098-4530-ad3e-59615b8572ac', $restriction->id);
        $this->assertEquals('France', $restriction->origin->name);
        $this->assertEquals('country', $restriction->origin->type);
        $this->assertEquals('FR', $restriction->origin->countryCode);
        $this->assertEquals('Spain', $restriction->destination->name);
        $this->assertEquals('country', $restriction->destination->type);
        $this->assertEquals('ES', $restriction->destination->countryCode);
        $this->assertEquals('restricted', $restriction->authorizationStatus);
        $this->assertEquals('Travelling from France to Spain is restricted', $restriction->summary);
        $this->assertEquals('Only business related travel is allowed.', $restriction->details);
        $this->assertEquals('2020-10-16', $restriction->startDate);
        $this->assertEquals('2020-10-18', $restriction->endDate);
        $this->assertEquals('2020-09-16T14:54:59.944581+00:00', $restriction->updatedAt);
        $this->assertEquals(1, count($restriction->requirements));
        $this->assertEquals('quarantine', $restriction->requirements[0]->category->id);
        $this->assertEquals('Quarantine', $restriction->requirements[0]->category->name);
        $this->assertEquals('quarantine_required', $restriction->requirements[0]->subCategory->id);
        $this->assertEquals('Quarantine required', $restriction->requirements[0]->subCategory->name);
        $this->assertEquals(
            'Travelers are required to quarantine for 14 days prior or after entering this destination',
            $restriction->requirements[0]->summary
        );
        $this->assertEquals(
            'Travelers arriving into Spain are required to go into quarantine',
            $restriction->requirements[0]->details
        );
        $this->assertEquals('2020-10-02', $restriction->requirements[0]->startDate);
        $this->assertEquals('2020-10-18', $restriction->requirements[0]->endDate);
        $this->assertEquals(1, count($restriction->requirements[0]->documents));
        $this->assertEquals('FCS form', $restriction->requirements[0]->documents[0]->name);
        $this->assertEquals('https://www.spth.gob.es/create', $restriction->requirements[0]->documents[0]->documentUrl);
        $this->assertEquals('https://www.spth.gob.es/download.pdf', $restriction->requirements[0]->documents[0]->downloadUrl);
    }

    public function testGettingLocalSummary()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('travelsafe/guidelines?location_type=country_code&location=ES')
            ->andReturn(file_get_contents('tests/stubs/summary.json'));
        $summary = $this->travelSafe->localSummary('ES', 'country_code');
        $this->assertTrue(is_a($summary, Summary::class));
        $this->assertEquals('872aca1b-04ca-47d2-83d8-493b4c7b6148', $summary->id);
        $this->assertEquals('While traveling in Spain you will be required to follow the guidelines introduced by the local government. These regulations are based on risk levels and aimed at improving your safety.', $summary->summary);
        $this->assertEquals('', $summary->details);
        $this->assertEquals('high', $summary->riskLevel->id);
        $this->assertEquals('High', $summary->riskLevel->name);
        $this->assertEquals('Covid cases are multiplying', $summary->riskLevel->details);
        $this->assertEquals('0.892057388196839', $summary->riskLevel->data->r_number);
        $this->assertEquals('Spain', $summary->location->name);
        $this->assertEquals('country', $summary->location->type);
        $this->assertEquals('ES', $summary->location->countryCode);
        $this->assertEquals('2020-10-19T10:08:53.777Z', $summary->updatedAt);
        $this->assertEquals(1, count($summary->guidelines));
        $this->assertEquals('use_of_mask', $summary->guidelines[0]->category->id);
        $this->assertEquals('Use of masks', $summary->guidelines[0]->category->name);
        $this->assertEquals('required', $summary->guidelines[0]->subCategory->id);
        $this->assertEquals('Required', $summary->guidelines[0]->subCategory->name);
        $this->assertEquals('Use of masks is required', $summary->guidelines[0]->summary);
        $this->assertEquals('Use of masks in all the public areas is required, including open spaces. You might face fines up to €3000 if stopped by the police without mask.', $summary->guidelines[0]->details);
        $this->assertEquals('1/3', $summary->guidelines[0]->severity);
        $this->assertEquals('Spain Travel Health', $summary->infoSource->name);
        $this->assertEquals('https://www.spth.gob.es/', $summary->infoSource->url);
    }

    public function testAirlineSafetyMeasures()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('travelsafe/airline_safety_measures?iata_code=iata')
            ->andReturn(file_get_contents('tests/stubs/airlineMeasures.json'));
        $safetyMeasure = $this->travelSafe->airlineSafetyMeasures('iata');
        $this->assertEquals('Lufthansa', $safetyMeasure->airline->name);
        $this->assertEquals('LH', $safetyMeasure->airline->iataCode);
        $this->assertEquals(1, count($safetyMeasure->safetyMeasures));
        $this->assertEquals('boarding_or_dissembarking_measurements', $safetyMeasure->safetyMeasures[0]->category->id);
        $this->assertEquals('New boarding and disembarking measures', $safetyMeasure->safetyMeasures[0]->category->name);
        $this->assertEquals('true', $safetyMeasure->safetyMeasures[0]->subCategory->id);
        $this->assertEquals('true', $safetyMeasure->safetyMeasures[0]->subCategory->name);
        $this->assertEquals('Travelers should wait until their boarding group is called before using the automatic gates to board the aircraft. Disinfectant wipes will also be provided to passengers for the purpose of cleaning the surfaces in and around their seats.', $safetyMeasure->safetyMeasures[0]->details);
        $this->assertEquals('To help passengers can keep a safe distance from one another.', $safetyMeasure->safetyMeasures[0]->summary);
        $this->assertEquals("Lufthansa' info source", $safetyMeasure->infoSource->name);
        $this->assertEquals('https://www.lufthansa.com/de/en/protection-measures', $safetyMeasure->infoSource->url);
        $this->assertEquals('2020-10-19T12:14:42.041298+00:00', $safetyMeasure->updatedAt);
    }

    public function testGettingAllLocationTypes()
    {
        $this->assertEquals(
            [
                'country_code',
                'iata_code',
            ],
            $this->travelSafe->locationTypes()
        );
    }
}
