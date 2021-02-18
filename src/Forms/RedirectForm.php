<?php declare(strict_types=1);

namespace VitesseCms\Sef\Forms;

use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Sef\Models\Redirect;
use VitesseCms\Sef\Repositories\AdminRepositoryInterface;

class RedirectForm extends AbstractFormWithRepository
{
    /**
     * @var Redirect
     */
    protected $_entity;

    /**
     * @var AdminRepositoryInterface
     */
    protected $repositories;

    public function buildForm(): FormWithRepositoryInterface
    {
        $languageOptionss = [['value' => '', 'label' => '%FORM_CHOOSE_AN_OPTION%', 'selected' => false]];
        $languages = $this->repositories->language->findAll(null, false);

        while ($languages->valid()) :
            $language = $languages->current();

            $selected = false;
            if ($this->_entity->getLanguageShort() === $language->getShortCode()) :
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
