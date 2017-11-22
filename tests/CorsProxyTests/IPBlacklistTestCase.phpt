<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Exception\FileNotFoundException;
use HtmlDriven\CorsProxy\IPBlacklist;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * IPBlacklistTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 */
final class IPBlacklistTestCase extends TestCase
{
    /**
     * @return void
     */
    public function testLoadFromNonexistingFileThrowsFileNotFoundException()
    {
        $ipBlacklistFile = __DIR__ . '/../data/app/ip.blacklist-fake';

        Assert::throws(function () use ($ipBlacklistFile) {
            IPBlacklist::loadFromFile($ipBlacklistFile);
        }, FileNotFoundException::class, "File '{$ipBlacklistFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testLoadFromFileReturnsCorrectData()
    {
        $ipBlacklistFile = __DIR__ . '/../data/app/ip.blacklist';
        $ipBlacklist = IPBlacklist::loadFromFile($ipBlacklistFile);

        Assert::same([
            '77.87.234.211',
            '232.202.92.180',
            '148.10.109.70',
            '209.185.147.236',
            '175.118.58.174',
        ], $ipBlacklist->getIps());
    }
}

run(new IPBlacklistTestCase());
