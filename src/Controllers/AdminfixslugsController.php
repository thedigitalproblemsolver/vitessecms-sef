<?php declare(strict_types=1);

namespace VitesseCms\Sef\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Content\Models\Item;
use VitesseCms\Content\Utils\SeoUtil;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Sef\Repositories\AdminRepositoriesInterface;

class AdminfixslugsController extends AbstractAdminController implements AdminRepositoriesInterface
{
    public function IndexAction()
    {
        $items = $this->repositories->item->findAll(new FindValueIterator([new FindValue('slug', null)]), true, 99999);
        $this->view->setVar(
            'content',
            $this->eventsManager->fire(ViewEnum::RENDER_TEMPLATE_EVENT, new RenderTemplateDTO(
                'fix_slug',
                $this->router->getModuleName() . '/src/Resources/views/admin/',
                [
                    'amount' => $items->count()
                ]
            ))
        );
        $this->prepareView();
    }

    public function fixslugsAction()
    {
        $items = $this->repositories->item->findAll(new FindValueIterator([new FindValue('slug', null)]), true, 999);

        while ($items->valid()) :
            $item = $items->current();
            SeoUtil::setSlugsOnItem(
                $item,
                $this->repositories->datagroup,
                $this->repositories->datafield,
                $this->repositories->item,
                $this->repositories->language,
                $this->repositories->datagroup->getById($item->getDatagroup(), false)
            )->save();
            $this->clearCache($item);
            $this->log->write(
                $item->getId(),
                Item::class,
                'Slug fixed for ' . $item->getNameField() . ' to <a href="' . $this->url->getBaseUri() . $item->getSlug() . '" target="_blank">view page</a>'
            );
            $items->next();
        endwhile;

        $this->flash->setSucces($items->count() . ' slugs fixed');
        $this->redirect();
    }

    protected function clearCache(Item $item): void
    {
        foreach ($item->getSlugs() as $key => $slug) :
            $this->cache->delete($this->cache->getCacheKey($key . $slug));
        endforeach;
    }
}
