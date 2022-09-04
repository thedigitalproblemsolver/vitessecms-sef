<?php declare(strict_types=1);

namespace VitesseCms\Sef\Models;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Sef\Utils\SefUtil;

class Redirect extends AbstractCollection
{
    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $to;

    /**
     * @var string
     */
    public $languageShort;

    public function setFrom(string $from): Redirect
    {
        $this->from = $from;

        return $this;
    }

    public function setTo(string $to): Redirect
    {
        $this->to = $to;

        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getLanguageShort(): ?string
    {
        return $this->languageShort;
    }

    public function setLanguageShort(?string $languageShort): Redirect
    {
        $this->languageShort = $languageShort;

        return $this;
    }

    //TODO move to listener/mustache?

    public function afterFetch()
    {
        $this->set('name', $this->_('from') . ' > ' . $this->_('to'));
        parent::afterFetch();
        if (AdminUtil::isAdminPage()) :
            $iconClass = 'flag-icon fa fa-globe';
            if ($this->_('languageShort')) :
                $iconClass = 'flag-icon flag-icon-' . $this->_('languageShort');
            endif;
            $this->set(
                'adminListName',
                '<i class="' . $iconClass . ' mr-2"></i>' .
                $this->_('from') . ' > ' . $this->_('to')
            );
        endif;
    }

    //TODO move to listener
    public function validation(): bool
    {
        $this->set('from', SefUtil::fixSlashes($this->_('from')));
        $this->set('to', SefUtil::fixSlashes($this->_('to')));

        if ($this->_('from') === $this->_('to')) :
            return false;
        endif;

        if ($this->getId() === null) :
            Redirect::setFindPublished(false);
            Redirect::setFindValue('from', $this->_('from'));
            Redirect::setFindValue('to', $this->_('to'));
            if (Redirect::count() > 0) :
                return false;
            endif;
        endif;

        return true;
    }
}
