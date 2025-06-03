<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class VehicleControllerTest extends WebTestCase
{
    public function testMakersByType()
    {
        $client = static::createClient();
        $client->request('GET', '/api/vehicle/2', [], [], [
            'HTTP_X_AUTH_TOKEN' => '74716d8dd44c2aafcc3e6b7c5ada9e31c1cd97715a0f5d615fa9dff5fe957649',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testOnlyAuthorizedUserCanAccessVehicleEndpoint(): void
    {
        $client = static::createClient();

        // Get a user with a valid API token from the test database
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'apitest@example.com']);
        $this->assertNotNull($user, 'Test user not found in database');
        $token = $user->getApiToken();

        // 1. Request WITH valid API token (should succeed)
        $client->request('GET', '/api/vehicle/2', [], [], [
            'HTTP_X_AUTH_TOKEN' => $token,
        ]);
        $this->assertResponseIsSuccessful(); // 2xx

        // 2. Request WITHOUT token (should fail)
        $client->request('GET', '/api/vehicle/2');
        $this->assertResponseStatusCodeSame(401);

        // 3. Request WITH invalid token (should fail)
        $client->request('GET', '/api/vehicle/2', [], [], [
            'HTTP_X_AUTH_TOKEN' => 'invalid-token',
        ]);
        $this->assertResponseStatusCodeSame(401);
    }
}
