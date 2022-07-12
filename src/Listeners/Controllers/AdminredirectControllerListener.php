<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;

class AdminredirectControllerListener
{
    public function adminListFilter(
        Event                   $event,
        AbstractAdminController $controller,
        AdminlistFormInterface  $form
    ): string
    {
        $form->addText('From', 'filter[from]');
        $form->addText('To', 'filter[to]');
        $form->addPublishedField($form);

        return $form->renderForm(
            $controller->getLink() . '/' . $controller->router->getActionName(),
            'adminFilter'
        );
    }
}