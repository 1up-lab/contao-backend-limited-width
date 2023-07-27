<?php

declare(strict_types=1);

namespace Oneup\ContaoBackendLimitedWidthBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Oneup\ContaoBackendLimitedWidthBundle\OneupContaoBackendLimitedWidthBundle;

final class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(OneupContaoBackendLimitedWidthBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                ]),
        ];
    }
}
