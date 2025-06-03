<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VehicleTechDetailControllerTest extends WebTestCase
{
    public function testPatchVehicleTechDetailReturns404ForMissing(): void
    {
        $client = static::createClient();
        $client->request('PATCH', '/api/vehicle-tech-detail/999', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode(['topSpeed' => 250]));

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
