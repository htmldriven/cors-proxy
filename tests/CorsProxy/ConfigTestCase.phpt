<?php

namespace HtmlDrivenTests\CorsProxy;

use HtmlDriven\CorsProxy\Config;
use HtmlDriven\CorsProxy\FileNotFoundException;
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
			$errorTemplateFile = __DIR__ . '/../data/app/templates/foo/error.phtml'
		);
		
		Assert::same($urlParameterName, $config->getUrlParameterName());
		Assert::same($userAgent, $config->getUserAgent());
		Assert::same($templateFile, $config->getTemplateFile());
		Assert::same($sitemapPath, $config->getSitemapPath());
		Assert::same($sitemapTemplateFile, $config->getSitemapTemplateFile());
		Assert::same($errorTemplateFile, $config->getErrorTemplateFile());
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
		
		Assert::throws(function() use ($urlParameterName, $userAgent, $templateFile, $sitemapPath, $sitemapTemplateFile, $errorTemplateFile) {
			new Config(
				$urlParameterName,
				$userAgent,
				$templateFile,
				$sitemapPath,
				$sitemapTemplateFile,
				$errorTemplateFile
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
		
		Assert::throws(function() use ($urlParameterName, $userAgent, $templateFile, $sitemapPath, $sitemapTemplateFile, $errorTemplateFile) {
			new Config(
				$urlParameterName,
				$userAgent,
				$templateFile,
				$sitemapPath,
				$sitemapTemplateFile,
				$errorTemplateFile
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
		
		Assert::throws(function() use ($urlParameterName, $userAgent, $templateFile, $sitemapPath, $sitemapTemplateFile, $errorTemplateFile) {
			new Config(
				$urlParameterName,
				$userAgent,
				$templateFile,
				$sitemapPath,
				$sitemapTemplateFile,
				$errorTemplateFile
			);
		}, FileNotFoundException::class, "File '{$errorTemplateFile}' does not exist or not accessible.");
	}
}

run(new ConfigTestCase());
