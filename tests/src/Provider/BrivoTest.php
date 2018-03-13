<?php

namespace Drewhammond\OAuth2\Client\Test\Provider;

use Drewhammond\OAuth2\Client\Provider\Brivo;
use League\OAuth2\Client\Token\AccessToken;
use Mockery as mock;
use PHPUnit\Framework\TestCase;

class BrivoTest extends TestCase
{
    /** @var Brivo */
    protected $provider;

    protected function setUp()
    {
        $this->provider = new Brivo([
            'clientId'     => 'TEST_CLIENT_ID_VALUE',
            'clientSecret' => 'TEST_CLIENT_SECRET_VALUE',
        ]);
    }

    public function tearDown()
    {
        mock::close();
        parent::tearDown();
    }

    public function testInit()
    {
        $this->assertTrue(true);
    }

    public function testGetAccessToken()
    {
        $response = mock::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn('{"access_token":"TEST_ACCESS_TOKEN_VALUE","token_type":"bearer","refresh_token":"TEST_REFRESH_TOKEN_VALUE","expires_in":59,"scope":"brivo.api","jti":"00000000-a0a0-a0a0-a0a0-000000000000"}');
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'application/json;charset=UTF-8']);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $client = mock::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);
        $token = $this->provider->getAccessToken('client_credentials');
        $this->assertEquals(time() + 59, $token->getExpires());

        $this->assertEquals('TEST_ACCESS_TOKEN_VALUE', $token->getToken());
        $this->assertEquals('TEST_REFRESH_TOKEN_VALUE', $token->getRefreshToken());

        $this->assertEquals('brivo.api', $token->getValues()['scope']);
        $this->assertEquals('00000000-a0a0-a0a0-a0a0-000000000000', $token->getValues()['jti']);
        $this->assertEquals('bearer', $token->getValues()['token_type']);
        $this->assertFalse($token->hasExpired());
        $this->assertNull($token->getResourceOwnerId());
    }

    public function testGetResourceOwnerDetailsUrl()
    {
        $token = new AccessToken(['access_token' => 'TEST_ACCESS_TOKEN_VALUE', 'expires_in' => 300]);
        $this->assertEquals('', $this->provider->getResourceOwnerDetailsUrl($token));
    }

    /**
     * Pointless test
     */
    public function testGetBaseAuthorizationUrl()
    {
        $this->assertEquals('https://auth.brivo.com/oauth/authorize', $this->provider->getBaseAuthorizationUrl());
    }

    /**
     * Pointless test
     */
    public function testGetBaseAccessTokenUrl()
    {
        $this->assertEquals('https://auth.brivo.com/oauth/token', $this->provider->getBaseAccessTokenUrl([]));
    }
}