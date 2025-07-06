<?php

namespace Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Fixtures\FixtureInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationTestCase extends WebTestCase
{
    protected static KernelBrowser $client;

    public static function initialize(): KernelBrowser
    {
        self::$client = parent::createClient();
        $container = self::getContainer();
        $kernel = self::getContainer()->get('kernel');

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $entityManager = $container->get('doctrine')->getManager();
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        return self::$client;
    }

    /**
     * @param array<int, FixtureInterface> $fixtures
     * @return void
     */
    protected function loadFixtures(array $fixtures): void
    {
        foreach ($fixtures as $fixture) {
            $fixture->load(self::getContainer());
        }

        self::$client->getContainer()->get(EntityManagerInterface::class)->flush();
    }
}
