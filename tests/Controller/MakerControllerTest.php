<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MakerControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/makers/by-type/suv', [], [], []);
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }
}
