<?php

namespace HtmlDrivenTests\CorsProxy;

use Guzzle\Http\Exception\CurlException;
use HtmlDriven\CorsProxy\RequestHandler;
use HtmlDrivenTests\CorsProxy\Mock\FakeClient;
use HtmlDrivenTests\CorsProxy\Mock\FakeRequest;
use Tester\Assert;
use Tester\TestCase;
use function run;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Tests invalid host name results in 404 HTTP error.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 * 
 * @testCase
 * @httpCode 404
 */
class RequestHandlerError404TestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testError404()
	{
		$statusCode = 404;
		$headers = [];
		$body = 'Lorem ipsum dolor sit amet.';
		
		$response = function() {
			$curlException = new CurlException();
			$curlException->setError('Invalid host name.', CURLE_COULDNT_RESOLVE_HOST);
			throw $curlException;
		};
		
		$fakeRequest = new FakeRequest($response);
		$fakeClient = new FakeClient($fakeRequest);
		
		$requestHandler = new RequestHandler($fakeClient);
		
		ob_start();
		$requestHandler->handleRequest('http://unknown-host-123-abc.htmldriven.com/sample.json');
		$contents = ob_get_clean();
		
		$json = [
			'success' => FALSE,
			'error' => "Unable to handle request: CURL failed with message 'Invalid host name.'.",
			'body' => NULL,
		];
		
		Assert::same(json_encode($json), $contents);
	}
}

run(new RequestHandlerError404TestCase());
