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
			$sitemapFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml'
		);
		
		Assert::same($urlParameterName, $config->getUrlParameterName());
		Assert::same($userAgent, $config->getUserAgent());
		Assert::same($templateFile, $config->getTemplateFile());
		Assert::same($sitemapPath, $config->getSitemapPath());
		Assert::same($sitemapFile, $config->getSitemapFile());
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
		$sitemapFile = __DIR__ . '/../data/app/templates/foo/sitemap.pxml';
		
		Assert::throws(function() use ($urlParameterName, $userAgent, $templateFile, $sitemapPath, $sitemapFile) {
			new Config(
				$urlParameterName,
				$userAgent,
				$templateFile,
				$sitemapPath,
				$sitemapFile
			);
		}, FileNotFoundException::class, "File '{$templateFile}' does not exist or not accessible.");
		
	}
	
	/**
	 * @return void
	 */
	public function testInvalidSitemapFile()
	{
		$urlParameterName = 'my-url';
		$userAgent = 'My CORS proxy';
		$templateFile = __DIR__ . '/../data/app/templates/foo/frontend.phtml';
		$sitemapPath = '/sitemap.xml';
		$sitemapFile = __DIR__ . '/../data/app/templates/foo/invalid-sitemap.pxml';
		
		Assert::throws(function() use ($urlParameterName, $userAgent, $templateFile, $sitemapPath, $sitemapFile) {
			new Config(
				$urlParameterName,
				$userAgent,
				$templateFile,
				$sitemapPath,
				$sitemapFile
			);
		}, FileNotFoundException::class, "File '{$sitemapFile}' does not exist or not accessible.");
	}
}

run(new ConfigTestCase());
