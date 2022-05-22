<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * Manager test method.
 */
class EndpointTest extends TestCase
{

    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['http_errors' => false]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    /**
     * @test
     */
    public function reset()
    {
        $response = $this->http->request('POST', SERVER . 'reset/');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=utf-8", $contentType);
    }

    /**
     * @test
     */
    public function getNonExistBalance()
    {
        $response = $this->http->request('GET', SERVER . 'balance?account_id=1234');

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals(0, $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function createNewAccount()
    {
        //{"type":"deposit", "destination":"100", "amount":10}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type' => 'deposit',
                    'destination' => '100',
                    'amount' => '10'
                ]
            ]
        );

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals('{"destination":{"id":"100","balance":10}}', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function depositToExistsAccount()
    {
        //{"type":"deposit", "destination":"100", "amount":10}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type'        => 'deposit',
                    'destination' => '100',
                    'amount'      => '10'
                ]
            ]
        );

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals('{"destination":{"id":"100","balance":20}}', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function getExistsAccount1()
    {
        $response = $this->http->request('GET', SERVER . 'balance?account_id=100');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(20, $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function withdrawNonExistsAccount()
    {
        //{"type":"withdraw", "origin":"200", "amount":10}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type'        => 'withdraw',
                    'origin'      => '200',
                    'amount'      => '10'
                ]
            ]
        );


        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals(0, $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function withdrawExistsAccount()
    {
        //{"type":"withdraw", "origin":"100", "amount":5}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type'        => 'withdraw',
                    'origin'      => '100',
                    'amount'      => '5'
                ]
            ]
        );

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals('{"origin":{"id":"100","balance":15}}', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function getExistsAccount2()
    {
        $response = $this->http->request('GET', SERVER . 'balance?account_id=100');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(15, $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function transferExistsAccount()
    {
        //{"type":"transfer", "origin":"100", "amount":15, "destination":"300"}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type'         => 'transfer',
                    'origin'       => '100',
                    'amount'       => '15',
                    'destination'  => '300'
                ]
            ]
        );

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals('{"origin":{"id":"100","balance":0},"destination":{"id":"300","balance":15}}', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function transferNonExistsAccount()
    {
        //{"type":"transfer", "origin":"100", "amount":15, "destination":"300"}
        $response = $this->http->request(
            'POST',
            SERVER . 'event/',
            [
                'json' => [
                    'type'         => 'transfer',
                    'origin'       => '200',
                    'amount'       => '15',
                    'destination'  => '300'
                ]
            ]
        );

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals('0', $response->getBody()->getContents());
    }
}
