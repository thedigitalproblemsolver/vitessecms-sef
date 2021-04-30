<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Core\AbstractController;

class InitiateListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(AbstractController::class, new AbstractControllerListener());
    }
}
