<?php declare(strict_types=1);

namespace VitesseCms\Sef\Repositories;

use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\Language\Repositories\LanguageRepository;

class AdminRepositoryCollection implements BaseRepositoriesInterface
{
    /**
     * @var LanguageRepository
     */
    public $language;

    public function __construct(
        LanguageRepository $languageRepository
    )
    {
        $this->language = $languageRepository;
    }
}
