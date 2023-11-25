<?php

declare(strict_types=1);

namespace VitesseCms\Sef\Forms;

use stdClass;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Language\Enums\LanguageEnum;
use VitesseCms\Language\Repositories\LanguageRepository;
use VitesseCms\Sef\Models\Redirect;

class RedirectForm extends AbstractFormWithRepository
{
    /**
     * @var Redirect
     */
    protected $entity;

    private LanguageRepository $languageRepository;

    public function __construct($entity = null, array $userOptions = [])
    {
        parent::__construct($entity, $userOptions);

        $this->languageRepository = $this->eventsManager->fire(LanguageEnum::GET_REPOSITORY->value, new stdClass());
    }

    public function buildForm(): FormWithRepositoryInterface
    {
        $languageOptionss = [['value' => '', 'label' => '%FORM_CHOOSE_AN_OPTION%', 'selected' => false]];
        $languages = $this->languageRepository->findAll(null, false);

        while ($languages->valid()) :
            $language = $languages->current();

            $selected = false;
            if ($this->entity->getLanguageShort() === $language->getShortCode()) :
                $selected = true;
            endif;

            $languageOptionss[] = [
                'value' => $language->getShortCode(),
                'label' => $language->getNameField(),
                'selected' => $selected,
            ];
            $languages->next();
        endwhile;

        $this->addText('%ADMIN_FROM%', 'from', (new Attributes())->setRequired())
            ->addText('%ADMIN_TO%', 'to', (new Attributes())->setRequired())
            ->addDropdown('%ADMIN_LANGUAGE%', 'language', (new Attributes())->setOptions($languageOptionss))
            ->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
