<?php

namespace Application;

use App\Entity\User;
use Fixtures\UserFixture;
use Infrastructure\ApplicationTestCase;

class CreateRecipeTest extends ApplicationTestCase
{
    private UserFixture $userFixture;

    public function setUp(): void
    {
        self::initialize();

        $user = new User();
        $user
            ->setEmail('owner@localhost')
            ->setPassword('password');

        $this->userFixture = new UserFixture($user);

        $fixture = [
            $this->userFixture,
        ];

        $this->loadFixtures($fixture);
    }

    public function test_createRecipeNotAllowedWithoutAuthentication()
    {
        self::$client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"name": "Test recipe"}'
        );

        $this->assertResponseStatusCodeSame(401);
    }

    public function test_createRecipe()
    {
        $this->userFixture->authenticate(self::$client);
        $content = json_encode([
            'title' => 'Test recipe',
            'difficulty' => 'easy',
            'description' => 'Une délicieuse recette de test'
        ]);


        self::$client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/ld+json'],
            $content
        );

        $this->assertResponseStatusCodeSame(201);
    }

}
