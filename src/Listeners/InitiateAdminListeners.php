<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Datagroup\Listeners\AdmindatagroupControllerListener;
use VitesseCms\Sef\Controllers\AdminredirectController;

class InitiateAdminListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(AdminredirectController::class,new AdminredirectControllerListener());
    }
}
