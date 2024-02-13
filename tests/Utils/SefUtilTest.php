<?php

declare(strict_types=1);

namespace VitesseCms\Sef\Tests\Utils;

use PHPUnit\Framework\TestCase;
use VitesseCms\Sef\Utils\SefUtil;

final class SefUtilTest extends TestCase
{
    public function testClientIsBotTrue(): void
    {
        $agents = [
            'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.6167.85 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool +https://search.google.com/structured-data/testing-tool)',
            'Mozilla/5.0 (compatible; adidxbot/2.0; +http://www.bing.com/bingbot.htm)',
            'msnbot/2.1',
            'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)',
            'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/W.X.Y.Z Mobile Safari/537.36 (compatible; Google-InspectionTool/1.0;)',
            'Mozilla/5.0 (Device; OS_version) AppleWebKit/WebKit_version (KHTML, like Gecko)Version/Safari_version Safari/WebKit_version (Applebot/Applebot_version)',
            'Mozilla/5.0 (compatible; BitSightBot/1.0)',
            'Mozilla/5.0 (compatible; Bytespider; spider-feedback@bytedance.com) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.0.0 Safari/537.36',
        ];

        foreach ($agents as $agent) {
            $this->assertSame(true,SefUtil::clientIsBot($agent));
        }
    }

    public function testClientIsBotFalse(): void
    {
        $this->assertSame(false,SefUtil::clientIsBot('Mozilla/5.0 (iPhone; CPU iPhone OS 17_2_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/604.1'));
    }

    public function testGenerateSlugFromString()
    {
        $this->assertSame('dit-is-een-slug',SefUtil::generateSlugFromString('dit is --een--slug'));
        $this->assertSame('dit-is-een-slug',SefUtil::generateSlugFromString('dit--is  een ---slug'));
        $this->assertNotSame('dit-is-een-slug',SefUtil::generateSlugFromString('dit--is  een  ---slug'));
    }
}