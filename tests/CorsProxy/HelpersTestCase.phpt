<?php

namespace HtmlDrivenTests\CorsProxy;

use HtmlDriven\CorsProxy\FileNotFoundException;
use HtmlDriven\CorsProxy\Helpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Helpers tests.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 * 
 * @testCase
 */
final class HelpersTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testCheckFileExists()
	{
		$file = __DIR__ . '/invalid-file.phtml';
		
		Assert::throws(function() use ($file) {
			Helpers::checkFileExists($file);
		}, FileNotFoundException::class, "File '$file' does not exist or not accessible.");
		
		Assert::noError(function() {
			Helpers::checkFileExists(__FILE__);
		});
	}
	
	/**
	 * @return void
	 */
	public function testAbsolutizeFilepath()
	{
		// no modification
		Assert::same('/test/foo.txt', Helpers::absolutizeFilepath('/var', '/test/foo.txt'));
		
		// current-dir link
		Assert::same('/var' . DIRECTORY_SEPARATOR . './test/foo.txt', Helpers::absolutizeFilepath('/var', './test/foo.txt'));
		
		// parent-dir link
		Assert::same('/var' . DIRECTORY_SEPARATOR . '../test/foo.txt', Helpers::absolutizeFilepath('/var', '../test/foo.txt'));
	}
}

run(new HelpersTestCase());
