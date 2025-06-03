<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VehicleTechDetailControllerTest extends WebTestCase
{
    public function testPatchVehicleTechDetailReturns404ForMissing(): void
    {
        $client = static::createClient();
        $client->request('PATCH', '/api/vehicle-tech-detail/999', [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_AUTH_TOKEN' => '74716d8dd44c2aafcc3e6b7c5ada9e31c1cd97715a0f5d615fa9dff5fe957649'
        ], json_encode(['topSpeed' => 250]));

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
