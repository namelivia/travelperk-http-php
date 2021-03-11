<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Users\Users;

class UsersTest extends TestCase
{
    private $travelPerk;
    private $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new Users($this->travelPerk, $this->mapper);
    }

    private function assertEqualsUsersStub($usersPage): void
    {
        $this->assertEquals(2, $usersPage->total);
        $this->assertEquals(0, $usersPage->offset);
        $this->assertEquals(10, $usersPage->limit);
        $this->assertEquals(2, count($usersPage->users));
        $this->assertEquals('8', $usersPage->users[0]->id);
        $this->assertEquals('boss@test.com', $usersPage->users[0]->userName);
        $this->assertEquals('Morrison', $usersPage->users[0]->name->lastName);
        $this->assertEquals('Boss', $usersPage->users[0]->name->firstName);
        $this->assertEquals('', $usersPage->users[0]->name->middleName);
        $this->assertEquals('MR', $usersPage->users[0]->name->title);
        $this->assertEquals('en', $usersPage->users[0]->preferredLanguage);
        $this->assertEquals('en-gb', $usersPage->users[0]->locale);
        $this->assertEquals(true, $usersPage->users[0]->active);
        $this->assertEquals('Boss', $usersPage->users[0]->jobTitle);
        $this->assertEquals(['+34 123456789'], $usersPage->users[0]->phoneNumbers);
        $this->assertEquals('Mrs. Morrison', $usersPage->users[0]->emergencyContact->name);
        $this->assertEquals('+34 987654321', $usersPage->users[0]->emergencyContact->phone);
        $this->assertEquals('7', $usersPage->users[1]->id);
        $this->assertEquals('manager@test.com', $usersPage->users[1]->userName);
        $this->assertEquals('Roberts', $usersPage->users[1]->name->lastName);
        $this->assertEquals('Manager', $usersPage->users[1]->name->firstName);
        $this->assertEquals('', $usersPage->users[1]->name->middleName);
        $this->assertEquals('MRS', $usersPage->users[1]->name->title);
        $this->assertEquals('en', $usersPage->users[1]->preferredLanguage);
        $this->assertEquals('en-gb', $usersPage->users[1]->locale);
        $this->assertEquals(true, $usersPage->users[1]->active);
        $this->assertEquals('Office Manager', $usersPage->users[1]->jobTitle);
        $this->assertEquals([], $usersPage->users[1]->phoneNumbers);
        $this->assertEquals(null, $usersPage->users[1]->emergencyContact);
    }

    public function testGettingAllUsersWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('users?offset=5&limit=10')
            ->andReturn(file_get_contents('tests/stubs/users.json'));
        $users = $this->users->query()
             ->setOffset(5)
             ->setLimit(10)
             ->get();
        $this->assertEqualsUsersStub($users);
    }
}
