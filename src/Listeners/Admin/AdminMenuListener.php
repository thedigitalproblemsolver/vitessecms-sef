<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners\Admin;

use Phalcon\Events\Event;
use VitesseCms\Admin\Models\AdminMenu;
use VitesseCms\Admin\Models\AdminMenuNavBarChildren;

class AdminMenuListener
{
    public function AddChildren(Event $event, AdminMenu $adminMenu): void
    {
        $children = new AdminMenuNavBarChildren();
        $children->addChild('SEF-redirects', 'admin/sef/adminredirect/adminList');
        $adminMenu->addDropdown('System', $children);
    }
}