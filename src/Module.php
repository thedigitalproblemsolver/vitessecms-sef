<?php

declare(strict_types=1);

namespace VitesseCms\Sef;

use Phalcon\Di\DiInterface;
use VitesseCms\Core\AbstractModule;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Sef');
    }
}
