<?php

declare(strict_types=1);

namespace VitesseCms\Sef\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Sef\Forms\RedirectForm;
use VitesseCms\Sef\Models\Redirect;

class AdminredirectController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Redirect::class;
        $this->classForm = RedirectForm::class;
    }
}
