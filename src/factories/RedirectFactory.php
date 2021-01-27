<?php declare(strict_types=1);

namespace VitesseCms\Sef\Factories;

use VitesseCms\Sef\Models\Redirect;

class RedirectFactory
{
    public static function create(string $from, string $to, string $languageShort = null, bool $published = false): Redirect
    {
        $collection = new Redirect();
        $collection->setFrom($from);
        $collection->setTo($to);
        $collection->setLanguageShort($languageShort);
        $collection->setPublished($published);

        return $collection;
    }
}
