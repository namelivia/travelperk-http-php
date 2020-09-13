# travelperk-http-php [![tag](https://img.shields.io/github/tag/namelivia/travelperk-http-php.svg)](https://github.com/namelivia/travelperk-http-php/releases) [![Build Status](https://travis-ci.com/namelivia/travelperk-http-php.svg?branch=master)](https://travis-ci.com/namelivia/travelperk-http-php) [![codecov](https://codecov.io/gh/namelivia/travelperk-http-php/branch/master/graph/badge.svg)](https://codecov.io/gh/namelivia/travelperk-http-php)

<p align="center">
  <img src="https://user-images.githubusercontent.com/1571416/89100428-2c30cd00-d3f7-11ea-9c4a-37b17f9e9ae4.png" alt="TravelPerk PHP SDK" />
</p>

## About

This is a package for acessing the [TravelPerk official Web API](https://developers.travelperk.com) from your PHP language project. It is designed so you can easily query and retrieve all data hold on their platform and accessible through the API.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
$ composer require namelivia/travelperk-http-php:~0.0.1
```

## Getting started

Before getting started retrieving querying information from the TravelPerk Web API you first need to [get an API Key](https://developers.travelperk.com/reference#authentication).

### Getting a TravelPerk instance

For querying the data you need to get a TravelPerk instance, and for doing so you need to pass your api key to the service provider, and a boolean indicating if you like to use the sandbox environment or not like this:
```php
use Namelivia\TravelPerk\ServiceProvider;
$isSandbox = false;
$travelperk = (new ServiceProvider())->build($apiKey, $isSandbox);
```

The sandbox environment is for testing purposes and its described [here](https://developers.travelperk.com/docs/postman-collection#step-2---configure-the-postman-environment).

### Retrieving data

Everything is ready, you can start asking for the data.
```php
$travelperk->expenses()->invoices()->all();
```
For further information refer to the documentation linked in the next section.

## Documentation

The full documentation can be found [in the wiki section of this github repository](https://github.com/namelivia/travelperk-http-php/wiki).
Also you can refer to the [official TravelPerk Web API documentation](https://developers.travelperk.com/reference)

## License

[MIT](LICENSE)

## Contributing
Any suggestion, bug reports, prs or any other kind enhacements are welcome. Just [open an issue first](https://github.com/namelivia/travelperk-http-php/issues/new), for creating a PR remember this project has linting checkings and unit tests so any PR should comply with both before beign merged, this checks will be automatically applied when opening or modifying the PRs.

## Local development

This project comes with a `docker-compose.yml` file so if you use Docker and docker-compose you can develop without installing anything on your local environment. Just run `docker-compose up --build` for the first time to setup the container and launch the tests. PHPUnit is configured as the entrypoint so just run `docker-compose up` everytime you want the tests to execute on the Dockerized PHP development container.
