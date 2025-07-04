<?php

namespace Application;

use Infrastructure\ApplicationTestCase;

class SmokeTest extends ApplicationTestCase
{
    public function testHomePage()
    {
        $client = self::initialize();
        $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
        $response = $client->getResponse();
        $this->assertStringContainsString('Welcome to the API!', $response->getContent());
    }
}
