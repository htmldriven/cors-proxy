<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Application;
use HtmlDriven\CorsProxy\Config;
use Tester\Assert;
use Tester\DomQuery;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Main application entry point frontend tests.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 */
final class ApplicationFrontendTestCase extends TestCase
{
	/** @var Config */
	private $fooConfig;

	protected function setUp()
	{
		parent::setUp();

		$_SERVER['REQUEST_URI'] = '';

		$this->fooConfig = new Config(
			'url',
			'CORS proxy test',
			__DIR__ . '/../data/app/templates/foo/frontend.phtml',
			'/custom-sitemap.xml',
			__DIR__ . '/../data/app/templates/foo/sitemap.pxml',
			__DIR__ . '/../data/app/templates/foo/error.phtml',
			[],
			false
		);
	}


	/**
	 * @return void
	 */
	public function testApplicationShowsDefaultFrontendTemplate()
	{
		$application = new Application();

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$dom = DomQuery::fromHtml($contents);

		Assert::true($dom->has('#about'));
		Assert::true($dom->has('#how-to-use'));
		Assert::true($dom->has('#setup'));
		Assert::true($dom->has('#license'));
	}

	/**
	 * @return void
	 */
	public function testApplicationShowsDefaultSitemap()
	{
		$_SERVER['REQUEST_URI'] = '/sitemap.xml';

		$application = new Application();

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$dom = DomQuery::fromXml($contents);
		$dom->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		Assert::true((bool) $dom->xpath('/s:urlset/s:url/s:loc[text() = "http://cors-proxy.htmldriven.com"]'));
	}

	/**
	 * @return void
	 */
	public function testApplicationShowsCustomFrontendTemplate()
	{
		$application = new Application($this->fooConfig);

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$dom = DomQuery::fromHtml($contents);

		Assert::true($dom->has('h1#hello-foo'));
	}

	/**
	 * @return void
	 */
	public function testApplicationShowsCustomSitemap()
	{
		$_SERVER['REQUEST_URI'] = '/custom-sitemap.xml';

		$application = new Application($this->fooConfig);

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$dom = DomQuery::fromXml($contents);
		$dom->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		Assert::true((bool) $dom->xpath('/s:urlset/s:url/s:loc[text() = "https://foo-cors-proxy.com"]'));
	}
}

run(new ApplicationFrontendTestCase());
