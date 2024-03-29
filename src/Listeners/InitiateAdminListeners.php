<?php
declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Sef\Controllers\AdminredirectController;
use VitesseCms\Sef\Listeners\Admin\AdminMenuListener;
use VitesseCms\Sef\Listeners\Controllers\AdminredirectControllerListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        $injectable->eventsManager->attach(AdminredirectController::class, new AdminredirectControllerListener());
    }
}
