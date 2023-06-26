<?php declare(strict_types=1);

namespace VitesseCms\Sef\Utils;

use Phalcon\Di\Di;
use VitesseCms\Core\Utils\UrlUtil;

class SefUtil
{
    public static function fixSlashes(string $slug): string
    {
        $file = str_replace('//', '/', Di::getDefault()->get('config')->get('webDir') . $slug);
        $urlExists = false;

        if (Di::getDefault()->get('config')->get('importUrl')) :
            $url = Di::getDefault()->get('config')->get('importUrl') . $slug;
            $urlExists = UrlUtil::exists($url);
        endif;

        if (!is_file($file) && !$urlExists) :
            $slug = rtrim($slug, '/') . '/';
            $slug = '/' . ltrim($slug, '/');
        endif;


        return $slug;
    }

    public static function clientIsBot(string $userAgent): bool
    {
        $userAgent = strtolower($userAgent);

        return
            str_contains($userAgent, 'googlebot') ||
            str_contains($userAgent, 'google-structured-data-testing-tool') ||
            str_contains($userAgent, 'bingbot') ||
            str_contains($userAgent, 'msnbot');
    }

    public static function generateSlugFromString(string $string): string
    {
        $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
        $string = str_replace(' ', '-', $string);
        
        return strtolower($string);
    }
}
