<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use VitesseCms\Core\AbstractController;
use VitesseCms\Core\Enum\ViewEnum;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Sef\Listeners\Admin\AdminMenuListener;
use VitesseCms\Sef\Listeners\Controllers\AbstractControllerListener;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if ($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $di->eventsManager->attach(AbstractController::class, new AbstractControllerListener());
        $di->eventsManager->attach(ViewEnum::SERVICE_LISTENER, new FrontendHtmlListener(
            $di->request,
            $di->url,
            $di->view,
            $di->setting,
            $di->view->hasCurrentItem() ? $di->view->getCurrentItem() : null
        ));
    }
}
