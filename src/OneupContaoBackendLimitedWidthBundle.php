<?php

declare(strict_types=1);

namespace Oneup\ContaoBackendLimitedWidthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OneupContaoBackendLimitedWidthBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
