<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\ServiceProvider;
use Mockery;

class FeatureTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
    }

	# TODO: This test is actually making an HTTP request
	# TODO: So as the api key is not a real one, this is failing.
    public function testCodeIsSet()
    {
        $this->markTestSkipped('Badly written test');
		$apiKey = 'apiKey';
		$travelPerk = (new ServiceProvider())->build($apiKey);
		var_dump($travelPerk->expenses()->invoiceProfiles()->all());
    }
}
