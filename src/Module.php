<?php declare(strict_types=1);

namespace VitesseCms\Sef;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\AbstractModule;
use Phalcon\DiInterface;
use VitesseCms\Language\Repositories\LanguageRepository;
use VitesseCms\Sef\Repositories\AdminRepositoryCollection;
use VitesseCms\Sef\Repositories\RedirectRepository;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Sef');

        if (AdminUtil::isAdminPage()) :
            $di->setShared('repositories', new AdminRepositoryCollection(
                new LanguageRepository()
            ));
        endif;
    }
}
