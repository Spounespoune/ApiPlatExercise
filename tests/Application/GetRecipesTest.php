<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\RecipeSkillLevel;
use App\Tests\Fixtures\RecipeFixture;
use Fixtures\UserFixture;
use Infrastructure\ApplicationTestCase;

class GetRecipesTest extends ApplicationTestCase
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

        $recipe = new Recipe();
        $recipe
            ->setTitle('Test recipe')
            ->setDescription('<DESCRIPTION>')
            ->setDifficulty(RecipeSkillLevel::EASY)
            ->setOwner($user)
        ;

        $recipeFixture = new RecipeFixture($recipe);

        $fixture = [
            $this->userFixture,
            $recipeFixture,
        ];

        $this->loadFixtures($fixture);
    }

    public function testGetRecipesFromApi(): void
    {
        $this->userFixture->authenticate(self::$client);

        $response = self::$client->request(
            'GET',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertResponseStatusCodeSame(200);

        $response = self::$client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('/api/contexts/Recipe', $responseData['@context']);
        $this->assertEquals('/api/recipes', $responseData['@id']);
        $this->assertEquals('Collection', $responseData['@type']);
        $this->assertEquals(1, $responseData['totalItems']);

        $recipes = $responseData['member'];

        $this->assertEquals('Test recipe', $recipes[0]['title']);
        $this->assertEquals('easy', $recipes[0]['difficulty']);
        $this->assertEquals('<DESCRIPTION>', $recipes[0]['description']);
        $this->assertEquals('owner@localhost', $recipes[0]['owner']['email']);
    }
}
