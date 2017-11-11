<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Application;
use Tester\Assert;
use Tester\DomQuery;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Checks whether invalid action results in HTTP 404 Not Found error.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 * @httpCode 404
 */
final class Application404TestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testApplicationShows404WhenActionNotValid()
	{
		$_SERVER['REQUEST_URI'] = '/foo-bar.php';

		$application = new Application();

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$dom = DomQuery::fromHtml($contents);

		Assert::true($dom->has('h1'));
		Assert::contains('Error 404', $contents);
	}
}

run(new Application404TestCase());
