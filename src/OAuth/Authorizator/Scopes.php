<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Authorizator;

use Namelivia\TravelPerk\Exceptions\InvalidScopeException;

class Scopes
{
    const SCOPES = ['expenses:read'];

    public function __construct(
        array $scopes
    ) {
        foreach ($scopes as $scope) {
            if (!in_array($scope, Scopes::SCOPES)) {
                throw new InvalidScopeException('The scope '.$scope.' is invalid');
            }
        }
        $this->scopes = $scopes;
    }

    public function asUrlParam()
    {
        return implode(' ', $this->scopes);
    }
}
