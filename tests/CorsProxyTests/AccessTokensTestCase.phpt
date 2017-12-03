<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Exception\FileNotFoundException;
use HtmlDriven\CorsProxy\AccessTokens;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * AccessTokensTestCase.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 */
final class AccessTokensTestCase extends TestCase
{
    /**
     * @return void
     */
    public function testLoadFromNonexistingFileThrowsFileNotFoundException()
    {
        $accessTokensFile = __DIR__ . '/../data/app/access.tokens-fake';

        Assert::throws(function () use ($accessTokensFile) {
            AccessTokens::loadFromFile($accessTokensFile);
        }, FileNotFoundException::class, "File '{$accessTokensFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testLoadFromFileReturnsCorrectData()
    {
        $accessTokensFile = __DIR__ . '/../data/app/access.tokens';
        $accessTokens = AccessTokens::loadFromFile($accessTokensFile);

        Assert::same([
            '84f1b8n4o55ult1q',
            'k03j5iplu88a52e6',
            'gnh1sho76lix4e8q',
        ], $accessTokens->getAll());
    }
}

run(new AccessTokensTestCase());
