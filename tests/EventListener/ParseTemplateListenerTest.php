<?php

declare(strict_types=1);

namespace Oneup\ContaoBackendLimitedWidthBundle\Tests\EventListener\ParseTemplateListener;

use Contao\BackendTemplate;
use Contao\BackendUser;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FrontendUser;
use Contao\Template;
use Oneup\ContaoBackendLimitedWidthBundle\EventListener\ParseTemplateListener;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class ParseTemplateListenerTest extends TestCase
{
    public function testDoesNothingIfFrontendTemplate(): void
    {
        $security = $this->createMock(Security::class);
        $contaoFramework = $this->createMock(ContaoFramework::class);

        $template = $this->createMock(Template::class);
        $template
            ->expects($this->never())
            ->method('getName')
        ;

        $listener = new ParseTemplateListener($security, $contaoFramework);
        $listener($template);
    }

    public function testDoesNothingIfNotBackendMainTemplate(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->expects($this->never())
            ->method('getUser')
        ;

        $contaoFramework = $this->createMock(ContaoFramework::class);

        $template = $this->createMock(BackendTemplate::class);
        $template
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('fe_page')
        ;

        $listener = new ParseTemplateListener($security, $contaoFramework);
        $listener($template);
    }

    public function testDoesNothingIfNoBackendUserIsPresent(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($this->createMock(FrontendUser::class))
        ;

        $contaoFramework = $this->createMock(ContaoFramework::class);
        $contaoFramework
            ->expects($this->never())
            ->method('getAdapter')
        ;

        $template = $this->createMock(BackendTemplate::class);
        $template
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('be_main')
        ;

        $listener = new ParseTemplateListener($security, $contaoFramework);
        $listener($template);
    }

    public function testDoesNothingIfLimitedWidthIsNotChecked(): void
    {
        $user = $this->createMock(BackendUser::class);
        $user
            ->expects($this->once())
            ->method('__get')
            ->with('limitedWidth')
            ->willReturn(false)
        ;

        $security = $this->createMock(Security::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;

        $contaoFramework = $this->createMock(ContaoFramework::class);
        $contaoFramework
            ->expects($this->never())
            ->method('getAdapter')
        ;

        $template = $this->createMock(BackendTemplate::class);
        $template
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('be_main')
        ;

        $listener = new ParseTemplateListener($security, $contaoFramework);
        $listener($template);
    }

    public function testAddsStyleSheet(): void
    {
        $user = $this->createMock(BackendUser::class);
        $user
            ->expects($this->once())
            ->method('__get')
            ->with('limitedWidth')
            ->willReturn(true)
        ;

        $security = $this->createMock(Security::class);
        $security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user)
        ;

        $contaoFramework = $this->createMock(ContaoFramework::class);
        $contaoFramework
            ->expects($this->exactly(2))
            ->method('getAdapter')
        ;

        $template = $this->createMock(BackendTemplate::class);
        $template
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('be_main')
        ;

        $listener = new ParseTemplateListener($security, $contaoFramework);
        $listener($template);
    }
}
