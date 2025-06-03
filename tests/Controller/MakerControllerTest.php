<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MakerControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/makers/by-type/suv', [], [], [
            'HTTP_X_AUTH_TOKEN' => '74716d8dd44c2aafcc3e6b7c5ada9e31c1cd97715a0f5d615fa9dff5fe957649',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }
}
