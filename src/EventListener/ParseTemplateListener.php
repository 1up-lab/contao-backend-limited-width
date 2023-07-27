<?php

declare(strict_types=1);

namespace Oneup\ContaoBackendLimitedWidthBundle\EventListener;

use Contao\BackendTemplate;
use Contao\BackendUser;
use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Template;
use Symfony\Bundle\SecurityBundle\Security;

final class ParseTemplateListener
{
    public function __construct(
        private readonly Security $security,
        private readonly ContaoFramework $contaoFramework,
    ) {
    }

    public function __invoke(Template $template): void
    {
        if (!$template instanceof BackendTemplate) {
            return;
        }

        if ('be_main' !== $template->getName() && !str_starts_with($template->getName(), 'be_main_')) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user instanceof BackendUser) {
            return;
        }

        if (false === (bool) $user->limitedWidth) {
            return;
        }

        /** @var Template $templateAdapter */
        $templateAdapter = $this->contaoFramework->getAdapter(Template::class);

        /** @var Controller $controllerAdapter */
        $controllerAdapter = $this->contaoFramework->getAdapter(Controller::class);

        $template->stylesheets .= $templateAdapter->generateStyleTag($controllerAdapter->addStaticUrlTo('bundles/oneupcontaobackendlimitedwidth/limited-width.min.css'), null, null);
    }
}
