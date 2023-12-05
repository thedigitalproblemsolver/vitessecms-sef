<?php

declare(strict_types=1);

namespace VitesseCms\Sef\Controllers;

use stdClass;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Content\Enum\ItemEnum;
use VitesseCms\Content\Models\Item;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Content\Utils\SeoUtil;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Datafield\Enum\DatafieldEnum;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Enums\DatagroupEnum;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Language\Enums\LanguageEnum;
use VitesseCms\Language\Repositories\LanguageRepository;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;

class AdminfixslugsController extends AbstractAdminController
{
    private LanguageRepository $languageRepository;
    private ItemRepository $itemRepository;
    private DatagroupRepository $datagroupRepository;
    private DatafieldRepository $datafieldRepository;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->languageRepository = $this->eventsManager->fire(LanguageEnum::GET_REPOSITORY->value, new stdClass());
        $this->itemRepository = $this->eventsManager->fire(ItemEnum::GET_REPOSITORY, new stdClass());
        $this->datagroupRepository = $this->eventsManager->fire(DatagroupEnum::GET_REPOSITORY->value, new stdClass());
        $this->datafieldRepository = $this->eventsManager->fire(DatafieldEnum::GET_REPOSITORY->value, new stdClass());
    }

    public function IndexAction()
    {
        $items = $this->itemRepository->findAll(new FindValueIterator([new FindValue('slug', null)]), true, 99999);
        $this->view->setVar(
            'content',
            $this->eventsManager->fire(
                ViewEnum::RENDER_TEMPLATE_EVENT,
                new RenderTemplateDTO(
                    'fix_slug',
                    $this->router->getModuleName() . '/src/Resources/views/admin/',
                    [
                        'amount' => $items->count()
                    ]
                )
            )
        );
        $this->prepareView();
    }

    public function fixslugsAction()
    {
        $items = $this->itemRepository->findAll(new FindValueIterator([new FindValue('slug', null)]), true, 999);

        while ($items->valid()) {
            $item = $items->current();
            SeoUtil::setSlugsOnItem(
                $item,
                $this->datagroupRepository,
                $this->datafieldRepository,
                $this->itemRepository,
                $this->languageRepository,
                $this->datagroupRepository->getById($item->getDatagroup(), false)
            )->save();
            $this->clearCache($item);
            $this->log->write(
                $item->getId(),
                Item::class,
                'Slug fixed for ' . $item->getNameField() . ' to <a href="' . $this->url->getBaseUri() . $item->getSlug(
                ) . '" target="_blank">view page</a>'
            );
            $items->next();
        }

        $this->flash->setSucces($items->count() . ' slugs fixed');
        $this->redirect();
    }

    protected function clearCache(Item $item): void
    {
        foreach ($item->getSlugs() as $key => $slug) {
            $this->cache->delete($this->cache->getCacheKey($key . $slug));
        }
    }
}
