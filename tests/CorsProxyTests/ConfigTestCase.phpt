<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Config;
use HtmlDriven\CorsProxy\Exception\FileNotFoundException;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Configuration object tests.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 */
final class ConfigTestCase extends TestCase
{
    /**
     * @return void
     */
    public function testConfigParameters()
    {
        $config = new Config(
            $urlParameterName = 'my-url',
            $userAgent = 'My CORS proxy',
            $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml',
            $sitemapPath = '/sitemap.xml',
            $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml',
            $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml',
            $ipBlacklistFile = null,
            $accessTokensFile = null,
            $databaseConfig = [
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
            ]
        );

        Assert::same($urlParameterName, $config->getUrlParameterName());
        Assert::same($userAgent, $config->getUserAgent());
        Assert::same($templateFile, $config->getTemplateFile());
        Assert::same($sitemapPath, $config->getSitemapPath());
        Assert::same($sitemapTemplateFile, $config->getSitemapTemplateFile());
        Assert::same($errorTemplateFile, $config->getErrorTemplateFile());
        Assert::same($ipBlacklistFile, $config->getIPBlacklistFile());
        Assert::same($accessTokensFile, $config->getAccessTokensFile());
        Assert::same($databaseConfig, $config->getDatabaseConfig());
    }

    /**
     * @return void
     */
    public function testInvalidTemplateFile()
    {
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/invalid-frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $ipBlacklistFile = null;
        $accessTokensFile = null;
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];

        Assert::throws(function () use (
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $ipBlacklistFile,
            $accessTokensFile,
            $databaseConfig
        ) {
            new Config(
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $ipBlacklistFile,
                $accessTokensFile,
                $databaseConfig
            );
        }, FileNotFoundException::class, "File '{$templateFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvalidSitemapTemplateFile()
    {
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/invalid-sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $ipBlacklistFile = null;
        $accessTokensFile = null;
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];

        Assert::throws(function () use (
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $ipBlacklistFile,
            $accessTokensFile,
            $databaseConfig
        ) {
            new Config(
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $ipBlacklistFile,
                $accessTokensFile,
                $databaseConfig
            );
        }, FileNotFoundException::class, "File '{$sitemapTemplateFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvaliErrorTemplateFile()
    {
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/invalid-error.phtml';
        $ipBlacklistFile = null;
        $accessTokensFile = null;
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];

        Assert::throws(function () use (
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $ipBlacklistFile,
            $accessTokensFile,
            $databaseConfig
        ) {
            new Config(
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $ipBlacklistFile,
                $accessTokensFile,
                $databaseConfig
            );
        }, FileNotFoundException::class, "File '{$errorTemplateFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvaliIPBlacklistFile()
    {
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $ipBlacklistFile = __DIR__ . '/../data/app/ip.blacklist-fake';
        $accessTokensFile = null;
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];

        Assert::throws(function () use (
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $ipBlacklistFile,
            $accessTokensFile,
            $databaseConfig
        ) {
            new Config(
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $ipBlacklistFile,
                $accessTokensFile,
                $databaseConfig
            );
        }, FileNotFoundException::class, "File '{$ipBlacklistFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvalidAccessTokensFile()
    {
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $ipBlacklistFile = __DIR__ . '/../data/app/ip.blacklist';
        $accessTokensFile = __DIR__ . '/../data/app/access.tokens-fake';
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];

        Assert::throws(function () use (
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $ipBlacklistFile,
            $accessTokensFile,
            $databaseConfig
        ) {
            new Config(
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $ipBlacklistFile,
                $accessTokensFile,
                $databaseConfig
            );
        }, FileNotFoundException::class, "File '{$accessTokensFile}' does not exist or not accessible.");
    }
}

run(new ConfigTestCase());
