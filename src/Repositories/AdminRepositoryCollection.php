<?php declare(strict_types=1);

namespace VitesseCms\Sef\Repositories;

use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Language\Repositories\LanguageRepository;

class AdminRepositoryCollection implements BaseRepositoriesInterface
{
    /**
     * @var LanguageRepository
     */
    public $language;

    /**
     * @var ItemRepository
     */
    public $item;

    /**
     * @var DatagroupRepository
     */
    public $datagroup;

    /**
     * @var DatafieldRepository
     */
    public $datafield;

    public function __construct(
        LanguageRepository  $languageRepository,
        ItemRepository      $itemRepository,
        DatagroupRepository $datagroupRepository,
        DatafieldRepository $datafieldRepository
    )
    {
        $this->language = $languageRepository;
        $this->item = $itemRepository;
        $this->datagroup = $datagroupRepository;
        $this->datafield = $datafieldRepository;
    }
}
