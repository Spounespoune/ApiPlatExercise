<?php

namespace App\Tests\Fixtures;

use App\Entity\Recipe;
use Fixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\Container;

readonly class RecipeFixture implements FixtureInterface
{
    public function __construct(private Recipe $recipe)
    {
    }

    public function load(Container $container): void
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $entityManager->persist($this->recipe);
    }
}
