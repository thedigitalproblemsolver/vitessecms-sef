<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Core\Services\ViewService;

class AbstractControllerListener
{
    public function prepareHtmlView(Event $event, ViewService $viewService): void
    {
        $this->setMetaInformation($viewService);
    }

    protected function setMetaInformation(ViewService $viewService): void
    {
        $viewService->set('metaTitle', $viewService->getCurrentItem()->getNameField());
        $viewService->set('metaKeywords', $viewService->getCurrentItem()->getNameField());
        $viewService->set('metaDescription', $viewService->getCurrentItem()->_('introtext'));
    }
}
