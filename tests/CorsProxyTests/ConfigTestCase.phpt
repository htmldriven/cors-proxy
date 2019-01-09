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
            $enabled = false,
            $urlParameterName = 'my-url',
            $userAgent = 'My CORS proxy',
            $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml',
            $sitemapPath = '/sitemap.xml',
            $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml',
            $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml',
            $databaseConfig = [
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
            ],
            $requestLogEnabled = false
        );

        Assert::same($enabled, $config->isEnabled());
        Assert::same($urlParameterName, $config->getUrlParameterName());
        Assert::same($userAgent, $config->getUserAgent());
        Assert::same($templateFile, $config->getTemplateFile());
        Assert::same($sitemapPath, $config->getSitemapPath());
        Assert::same($sitemapTemplateFile, $config->getSitemapTemplateFile());
        Assert::same($errorTemplateFile, $config->getErrorTemplateFile());
        Assert::same($databaseConfig, $config->getDatabaseConfig());
        Assert::same($requestLogEnabled, $config->isRequestLogEnabled());
    }

    /**
     * @return void
     */
    public function testInvalidTemplateFile()
    {
        $enabled = true;
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/invalid-frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];
        $requestLogEnabled = false;

        Assert::throws(function () use (
            $enabled,
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $databaseConfig,
            $requestLogEnabled
        ) {
            new Config(
                $enabled,
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $databaseConfig,
                $requestLogEnabled
            );
        }, FileNotFoundException::class, "File '{$templateFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvalidSitemapTemplateFile()
    {
        $enabled = true;
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/invalid-sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml';
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];
        $requestLogEnabled = false;

        Assert::throws(function () use (
            $enabled,
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $databaseConfig,
            $requestLogEnabled
        ) {
            new Config(
                $enabled,
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $databaseConfig,
                $requestLogEnabled
            );
        }, FileNotFoundException::class, "File '{$sitemapTemplateFile}' does not exist or not accessible.");
    }

    /**
     * @return void
     */
    public function testInvaliErrorTemplateFile()
    {
        $enabled = true;
        $urlParameterName = 'my-url';
        $userAgent = 'My CORS proxy';
        $templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
        $sitemapPath = '/sitemap.xml';
        $sitemapTemplateFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
        $errorTemplateFile = __DIR__ . '/../data/app/templates/foo/invalid-error.phtml';
        $databaseConfig = [
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
        ];
        $requestLogEnabled = false;

        Assert::throws(function () use (
            $enabled,
            $urlParameterName,
            $userAgent,
            $templateFile,
            $sitemapPath,
            $sitemapTemplateFile,
            $errorTemplateFile,
            $databaseConfig,
            $requestLogEnabled
        ) {
            new Config(
                $enabled,
                $urlParameterName,
                $userAgent,
                $templateFile,
                $sitemapPath,
                $sitemapTemplateFile,
                $errorTemplateFile,
                $databaseConfig,
                $requestLogEnabled
            );
        }, FileNotFoundException::class, "File '{$errorTemplateFile}' does not exist or not accessible.");
    }
}

run(new ConfigTestCase());
