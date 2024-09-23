<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class CarrierControllerTest extends WebTestCase
{
    public function testAddNewCarrier()
    {
        $client = static::createClient();
        $client->request('POST', '/api/carrier/new', [
            'name' => 'New Carrier'.rand(1, 1000),
            'carrierPriceRules' => [
                [
                    "type" => "fixed",
                    "fixedPrice" => 20,
                    "weightLimit" => 10,
                ],
            ],
        ], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());

    }

    public function testGetAllCarriers()
    {
        $client = static::createClient();
        $client->request('GET', '/api/carrier');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($client->getResponse()->getContent());
    }
}
