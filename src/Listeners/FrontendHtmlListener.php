<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Setting\Services\SettingService;

class FrontendHtmlListener
{
    public function __construct(public ViewService $viewService, private readonly SettingService $settingService, private readonly ?Item $currentItem)
    {
    }

    public function setFrontendVars(Event $event): void
    {
        $this->viewService->setVar('SEO_META_KEYWORDS', $this->settingService->getString('SEO_META_KEYWORDS'));
        $this->viewService->setVar('SEO_ROBOTS', $this->settingService->getString('SEO_ROBOTS'));
        $this->viewService->setVar('SEO_META_DESCRIPTION', $this->settingService->getString('SEO_META_DESCRIPTION'));
        $this->viewService->setVar('WEBSITE_DEFAULT_NAME', $this->settingService->getString('WEBSITE_DEFAULT_NAME'));
        if ($this->currentItem !== null) {
            $this->viewService->setVar('SEO_META_TITLE', $this->currentItem->getNameField());
        } else {
            $this->viewService->setVar('SEO_META_TITLE', $this->settingService->getString('SITE_TITLE_LABEL_MOTTO'));
        }
    }
}