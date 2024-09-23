<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class PackageControllerTest extends WebTestCase
{
        public function testAddNewPackage()
    {
        $client = static::createClient();
        $client->request('POST', '/api/package/new', [
            'weight' => 10,
            'carrier' => 1,
        ], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetAllPackages()
    {
        $client = static::createClient();
        $client->request('GET', '/api/package');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($client->getResponse()->getContent());
    }
}
