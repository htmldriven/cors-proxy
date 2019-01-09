<?php

namespace HtmlDriven\CorsProxyTests;

use Dibi\Connection as DibiConnection;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Message\RequestInterface;
use HtmlDriven\CorsProxy\Config;
use HtmlDriven\CorsProxy\RequestHandler;
use HtmlDriven\CorsProxyTests\Mock\FakeClient;
use HtmlDriven\CorsProxyTests\Mock\FakeRequest;
use Tester\Assert;
use Tester\TestCase;
use function run;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Tests invalid host name results in 400 HTTP error.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 * @httpCode 400
 */
class RequestHandlerError404TestCase extends TestCase
{
	/**
	 * @return void
	 */
	public function testError400()
	{
		$statusCode = 404;
		$headers = [];
		$body = 'Lorem ipsum dolor sit amet.';

		$config = new Config(
			true,
            'my-url',
            'My CORS proxy',
            __DIR__ . '/../data/app/templates/foo/frontend.phtml',
            '/sitemap.xml',
            __DIR__ . '/../data/app/templates/foo/sitemap.pxml',
            __DIR__ . '/../data/app/templates/foo/error.phtml',
            [
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1',
            ],
            false
        );

		$response = function() {
			$curlException = new RequestException('Could not connect.', CURLE_COULDNT_CONNECT);
			throw $curlException;
		};

		$fakeRequest = new FakeRequest($response);
		$fakeClient = new FakeClient($fakeRequest);

		$dibiConnection = new DibiConnection([
			'driver' => 'PDO',
			'dsn' => 'mysql:dbname=cors_proxy;host=' . MYSQL_HOST . ';charset=utf8mb4',
			'username' => 'cors_proxy',
		]);

		$requestHandler = new RequestHandler($config, $fakeClient, $dibiConnection);

		ob_start();
		$requestHandler->handleRequest(
			RequestInterface::GET,
			'https://unknown-host-123-cba.htmldriven.com/sample.json'
		);
		$contents = ob_get_clean();

		$json = [
			'success' => FALSE,
			'error' => "Unable to handle request: CURL failed with message 'Could not connect.'.",
			'body' => NULL,
		];

		Assert::same(json_encode($json), $contents);
	}
}

run(new RequestHandlerError404TestCase());
