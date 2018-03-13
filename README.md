# Brivo OnAir Provider for OAuth 2.0 Client

[![Build Status](https://travis-ci.org/drewhammond/oauth2-brivo.svg?branch=master)](https://travis-ci.org/drewhammond/oauth2-brivo)
[![License](https://img.shields.io/packagist/l/drewhammond/oauth2-brivo.svg)](https://github.com/drewhammond/oauth2-brivo/blob/master/LICENSE)
[![Latest Stable Version](https://img.shields.io/packagist/v/drewhammond/oauth2-brivo.svg)](https://packagist.org/packages/drewhammond/oauth2-brivo)

This package provides [Brivo OnAir](http://apidocs.brivo.com/) OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).


## Installation

To install, use composer:

```
$ composer require drewhammond/oauth2-brivo
```

## Usage

The example below is taken from a Laravel project with the `BRIVO_API_KEY`, `BRIVO_CLIENT_ID` and `BRIVO_CLIENT_SECRET` defined in the project .env file.


```php

  // Instantiate Availity provider
  $provider = new \Drewhammond\OAuth2\Client\Provider\Availity( [
    'clientId'     => getenv( 'AVAILITY_CLIENT_ID' ),
    'clientSecret' => getenv( 'AVAILITY_CLIENT_SECRET' ),
  ] );

  // Fetch access token using client_credentials grant (only grant type supported by Availity)
  $accessToken = $provider->getAccessToken( 'client_credentials' );

  // Do something with your access token...
  $token   = $accessToken->getToken();
  $expires = $accessToken->getExpires();

```

## Support

Please [open a new issue](https://github.com/drewhammond/oauth2-brivo/issues) if you run into any problems.

## License

MIT License

Copyright (c) 2018 [Drew Hammond](https://github.com/drewhammond)