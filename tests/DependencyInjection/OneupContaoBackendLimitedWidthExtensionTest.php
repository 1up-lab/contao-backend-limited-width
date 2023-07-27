<?php

declare(strict_types=1);

namespace Oneup\ContaoBackendLimitedWidthBundle\Tests\DependencyInjection;

use Oneup\ContaoBackendLimitedWidthBundle\DependencyInjection\OneupContaoBackendLimitedWidthExtension;
use Oneup\ContaoBackendLimitedWidthBundle\EventListener\ParseTemplateListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OneupContaoBackendLimitedWidthExtensionTest extends TestCase
{
    public function testLoadsServicesYaml(): void
    {
        $extension = new OneupContaoBackendLimitedWidthExtension();
        $containerBuilder = new ContainerBuilder();

        $extension->load([], $containerBuilder);
        $definitions = array_keys($containerBuilder->getDefinitions());

        self::assertContains(ParseTemplateListener::class, $definitions);
        self::assertCount(2, $definitions);
    }
}
