<?php
declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use VitesseCms\Core\AbstractController;
use VitesseCms\Core\Enum\ViewEnum;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Sef\Listeners\Admin\AdminMenuListener;
use VitesseCms\Sef\Listeners\Controllers\AbstractControllerListener;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        if ($injectable->user->hasAdminAccess()):
            $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $injectable->eventsManager->attach(AbstractController::class, new AbstractControllerListener());
        $injectable->eventsManager->attach(
            ViewEnum::SERVICE_LISTENER,
            new FrontendHtmlListener(
                $injectable->request,
                $injectable->url,
                $injectable->view,
                $injectable->setting,
                $injectable->view->hasCurrentItem() ? $injectable->view->getCurrentItem() : null
            )
        );
    }
}
