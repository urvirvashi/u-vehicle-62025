<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{
    public function testMakersByType()
    {
        $client = static::createClient();
        $client->request('GET', '/api/vehicle/1', [], [], []);
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }
}
