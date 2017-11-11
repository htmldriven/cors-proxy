<?php

namespace HtmlDriven\CorsProxyTests;

use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\RequestInterface;
use HtmlDriven\CorsProxy\RequestHandler;
use HtmlDriven\CorsProxyTests\Mock\FakeClient;
use HtmlDriven\CorsProxyTests\Mock\FakeRequest;
use Tester\Assert;
use Tester\TestCase;
use function run;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Successful request handling tests.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 */
class RequestHandlerSuccessTestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testSuccess()
	{
		$statusCode = 200;
		$headers = [];
		$body = 'Lorem ipsum dolor sit amet.';

		$response = new Response($statusCode, $headers, $body);

		$fakeRequest = new FakeRequest($response);
		$fakeClient = new FakeClient($fakeRequest);

		$requestHandler = new RequestHandler($fakeClient);

		ob_start();
		$requestHandler->handleRequest(
			RequestInterface::GET,
			'http://www.htmldriven.com/sample.json'
		);
		$contents = ob_get_clean();

		$json = [
			'success' => TRUE,
			'error' => NULL,
			'body' => 'Lorem ipsum dolor sit amet.',
		];

		Assert::same(json_encode($json), $contents);
	}
}

run(new RequestHandlerSuccessTestCase());
