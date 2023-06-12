<?php declare(strict_types=1);

namespace VitesseCms\Sef\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Helpers\ItemHelper;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Setting\Services\SettingService;

class FrontendHtmlListener
{
    public function __construct(
        public ViewService              $viewService,
        private readonly SettingService $settingService,
        private readonly ?Item          $currentItem
    )
    {
    }

    public function setFrontendVars(Event $event): void
    {
        $this->viewService->setVar('SEO_ROBOTS', $this->settingService->getString('SEO_ROBOTS'));
        $this->viewService->setVar('SEO_META_DESCRIPTION', $this->getMetaDescription());
        $this->viewService->setVar('WEBSITE_DEFAULT_NAME', $this->settingService->getString('WEBSITE_DEFAULT_NAME'));

        $this->viewService->setVar('SEO_META_TITLE', $this->getMetaTitle());
        $this->viewService->setVar('SEO_META_KEYWORDS', $this->getMetaKeywords());
    }

    private function getMetaDescription(): string
    {
        $description = '';
        if ($this->currentItem === null) {
            return $this->settingService->getString('SEO_META_DESCRIPTION');
        }

        if ($this->currentItem->has('introtext')) {
            $description = $this->currentItem->_('introtext');
        }

        if ($this->currentItem->has('bodytext')) {
            $description = preg_replace('/\{(.*)\}/i', '', $this->currentItem->_('bodytext'));
        }

        $description = trim(strip_tags($description));
        if (empty($description)) {
            $description = $this->settingService->getString('SEO_META_DESCRIPTION');
        }

        return str_split($description, 160)[0];
    }

    private function getMetaTitle(): string
    {
        if ($this->currentItem === null) {
            return $this->settingService->getString('SITE_TITLE_LABEL_MOTTO');
        }

        return $this->currentItem->getNameField();
    }

    private function getMetaKeywords(): string
    {
        if ($this->currentItem === null || !$this->currentItem->hasParent()) {
            return $this->settingService->getString('SEO_META_KEYWORDS');
        }

        $parents = ItemHelper::getPathFromRoot($this->currentItem);
        $parentTitles = [];
        foreach ($parents as $key => $item) {
            $parentTitles[] = $item->getNameField();
        }

        return implode(',', $parentTitles);
    }
}