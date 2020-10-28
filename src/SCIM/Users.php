<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Exceptions\NotImplementedException;
use Namelivia\TravelPerk\SCIM\Users\User;
use Namelivia\TravelPerk\SCIM\Users\Users as UsersType;

class Users
{
    private $travelPerk;

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
            '"urn:ietf:params:scim:schemas:extension:travelperk:2.0:User":',
            '"urn:ietf:params:scim:schemas:extension:enterprise:2.0:User":',
            '"$ref":',
        ], [
            '"travelperk_extension":',
            '"enterprise_extension":',
            '"ref":',
        ], $response);
        //TODO

        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * List all users associated to this account.
     */
    public function all(UsersInputParams $params = null): object
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->execute('get', implode('/', ['scim', 'Users']).$params, UsersType::class);
    }

    /**
     * Query users.
     */
    public function query(): UsersQuery
    {
        return new UsersQuery($this->travelPerk, $this->mapper);
    }

    /**
     * Retrieve a user from TravelPerk.
     */
    public function get(int $id): User
    {
        return $this->execute('get', implode('/', ['scim', 'Users', $id]), User::class);
    }

    /**
     * Deletes a user from TravelPerk.
     */
    public function delete(int $id): string
    {
        return $this->travelPerk->delete(implode('/', ['scim', 'Users', $id]));
    }

    /**
     * Make a new user in TravelPerk.
     */
    public function make(
        string $username,
        bool $active,
        string $givenName,
        string $familyName
    ): CreateUserQuery {
        $name = new NameInputParams($givenName, $familyName);

        return new CreateUserQuery($this->travelPerk, $this->mapper, $username, $active, $name);
    }

    /**
     * Create a new user in TravelPerk.
     */
    public function create(
        string $username,
        bool $active,
        string $givenName,
        string $familyName
    ): User {
        $name = new NameInputParams($givenName, $familyName);
        $params = new CreateUserInputParams($username, $active, $name);

        return $this->execute('post', implode('/', ['scim', 'Users']), User::class, $params->asArray());
    }

    /**
     * Update an existing user in TravelPerk.
     */
    public function update(int $id, UpdateUserInputParams $params): User
    {
        throw new NotImplementedException('https://github.com/namelivia/travelperk-http-php/issues/7');

        return $this->execute('patch', implode('/', ['scim', 'Users', $id]), User::class, $params->asArray());
    }

    /**
     * Replace an existing user in TravelPerk.
     */
    public function replace(int $id, ReplaceUserInputParams $params): User
    {
        return $this->execute('put', implode('/', ['scim', 'Users', $id]), User::class, $params->asArray());
    }

    /**
     * Modify an existing user in TravelPerk.
     */
    public function modify(
        int $id,
        string $username,
        bool $active,
        string $givenName,
        string $familyName
    ): ModifyUserRequest {
        $name = new NameInputParams($givenName, $familyName);

        return new ModifyUserRequest($id, $this->travelPerk, $this->mapper, $username, $active, $name);
    }

    /**
     * Get all genders.
     */
    public function genders(): array
    {
        return Gender::getConstantValues();
    }

    /**
     * Get all languages.
     */
    public function languages(): array
    {
        return Language::getConstantValues();
    }
}
