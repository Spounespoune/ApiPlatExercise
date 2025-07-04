<?php

namespace Fixtures;

use Symfony\Component\DependencyInjection\Container;

interface FixtureInterface
{
    public function load(Container $container): void;
}
