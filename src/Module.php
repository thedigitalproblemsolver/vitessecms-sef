<?php declare(strict_types=1);

namespace VitesseCms\Sef;

use Phalcon\Di\DiInterface;
use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Language\Repositories\LanguageRepository;
use VitesseCms\Sef\Repositories\AdminRepositoryCollection;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Sef');

        if (AdminUtil::isAdminPage()) :
            $di->setShared('repositories', new AdminRepositoryCollection(
                new LanguageRepository(),
                new ItemRepository(),
                new DatagroupRepository(),
                new DatafieldRepository()
            ));
        endif;
    }
}
