<?php

namespace HtmlDriven\CorsProxyTests;

use HtmlDriven\CorsProxy\Application;
use HtmlDriven\CorsProxy\Config;
use PDO;
use Tester\Assert;
use Tester\DomQuery;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Checks whether unauthorized access results in HTTP 401 Unauthorized.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 *
 * @testCase
 * @httpCode 401
 */
final class Application401TestCase extends TestCase
{
    /**
	 * @return void
	 */
	public function testApplicationReturns401WhenAccessTokenNotProvided()
	{
		$_SERVER['REQUEST_URI'] = '/?url=' . urlencode('http://htmldriven.com');
		$_GET['url'] = 'http://htmldriven.com';

		$parameters = [
			'urlParameterName' => 'url',
            'userAgent' => 'htmldriven/cors-proxy test',
            'templateFile' => __DIR__ . '/../data/app/templates/foo/frontend.phtml',
            'sitemapPath' => '/sitemap.xml',
            'sitemapTemplateFile' => __DIR__ . '/../data/app/templates/foo/sitemap.pxml',
            'errorTemplateFile' => __DIR__ . '/../data/app/templates/foo/error.phtml',
            'ipBlacklistFile' => null,
            'accessTokensFile' => __DIR__ . '/../data/app/access.tokens',
            'timezone' => 'UTC',
            'database' => [
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=cors_proxy;host=127.0.0.1;charset=utf8mb4',
                'username' => 'cors_proxy',
                'password' => '',
                'lazy' => true,
                'timezone' => '+00:00',
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+00:00\'',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ],
            ],
		];

		$config = new Config(
            $parameters['urlParameterName'],
            $parameters['userAgent'],
            $parameters['templateFile'],
            $parameters['sitemapPath'],
            $parameters['sitemapTemplateFile'],
            $parameters['errorTemplateFile'],
            $parameters['ipBlacklistFile'],
            $parameters['accessTokensFile'],
            $parameters['database']
        );

		$application = new Application($config);

		ob_start();
		$application->run();
		$contents = ob_get_clean();

		$json = json_decode($contents, true);
		Assert::type('array', $json);

		Assert::true(array_key_exists('success', $json));
		Assert::false($json['success']);

		Assert::true(array_key_exists('error', $json));
		Assert::same(
			'You are not allowed to use this service without valid access token.',
			$json['error']
		);

		Assert::true(array_key_exists('body', $json));
		Assert::null($json['body']);
	}
}

run(new Application401TestCase());
