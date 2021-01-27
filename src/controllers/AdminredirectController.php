<?php declare(strict_types=1);

namespace VitesseCms\Sef\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Core\Helpers\Item;
use VitesseCms\Sef\Forms\RedirectForm;
use VitesseCms\Sef\Models\Redirect;
use VitesseCms\Sef\Repositories\AdminRepositoriesInterface;

class AdminredirectController extends AbstractAdminController implements AdminRepositoriesInterface
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Redirect::class;
        $this->classForm = RedirectForm::class;
    }
}
