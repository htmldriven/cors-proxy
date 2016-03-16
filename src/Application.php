<?php

namespace HtmlDriven\CorsProxy;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use HtmlDriven\CorsProxy\Config;

/**
 * Main application entry point.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Application
{
	/** @var string */
	const DEFAULT_PROTOCOL = 'http';
	
	/** @var string */
	const DEFAULT_DOMAIN = 'cors-proxy.htmldriven.com';
	
	/** @var array */
	public $configDefaults = [
		'urlParameterName' => 'url',
		'userAgent' => 'htmldriven/cors-proxy 1.0',
		'templateFile' => __DIR__ . '/../app/templates/default/frontend.phtml',
		'sitemapPath' => '/sitemap.xml',
		'sitemapTemplateFile' => __DIR__ . '/../app/templates/default/sitemap.pxml',
		'errorTemplateFile' => __DIR__ . '/../app/templates/default/error.phtml',
	];
	
	/** @var Config */
	private $config;
	
	/** @var string[] */
	private $allowedActions = [
		'frontend',
		'sitemap',
	];
	
	/**
	 * @param Config|NULL If NULL, default config is created
	 */
	public function __construct(Config $config = NULL)
	{
		$this->config = ($config === NULL ? $this->createConfig() : $config);
	}
	
	/**
	 * Handles the request.
	 * 
	 * @return void
	 * @throws MalformedConfigFileException If configuration file parsing fails.
	 * @throws FileNotFoundException If template file does not exist.
	 */
	public function run()
	{
		$config = $this->config;
		
		// handle CORS proxy request if URL is set
		if (isset($_GET[$config->getUrlParameterName()])) {
			$url = (string) $_GET[$config->getUrlParameterName()];
			
			$client = $this->createClient($config);
			
			$requestHandler = new RequestHandler($client);
			$requestHandler->handleRequest($url);
		} else {
			// show frontend
			$this->showFrontEnd($config);
		}
	}
	
	/**
	 * @return Config
	 * @throws MalformedConfigFileException If configuration file parsing fails.
	 * @throws FileNotFoundException If template file does not exist.
	 */
	private function createConfig()
	{
		// config file is optional
		$iniFile = __DIR__ . '/../app/config/config.ini';
		if (is_file($iniFile)) {
			if (FALSE === ($config = parse_ini_file($iniFile, FALSE))) {
				throw new MalformedConfigFileException(sprintf("Unable to parse configuration file '%s'.", $iniFile));
			}
			$config = $config + $this->configDefaults;
		} else {
			$config = $this->configDefaults;
		}
		
		// absolutize filepaths
		$config['templateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['templateFile']);
		$config['sitemapTemplateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['sitemapTemplateFile']);
		$config['errorTemplateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['errorTemplateFile']);
		
		return new Config(
			$config['urlParameterName'],
			$config['userAgent'],
			$config['templateFile'],
			$config['sitemapPath'],
			$config['sitemapTemplateFile'],
			$config['errorTemplateFile']
		);
	}
	
	/**
	 * @param Config
	 * @return ClientInterface
	 */
	private function createClient(Config $config)
	{
		$client = new Client();
		$client->setUserAgent($config->getUserAgent());
		return $client;
	}
	
	/**
	 * @param Config
	 * @return void
	 */
	private function showFrontEnd(Config $config)
	{
		$isSecured = $this->isSecured();
		$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : static::DEFAULT_DOMAIN;
		$protocol = ($isSecured ? 'https' : 'http');
		$domainUrl = $protocol . '://' . $domain;		
		$basePath = '';
		
		$lastUpdate = $this->getLastUpdate($config);
		
		$action = NULL;
		
		$error = NULL;
		
		$requestUri = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : NULL;
		if (isset($requestUri)) {
			if ($requestUri === '/index.php') {
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $domainUrl . $basePath);
				return;
			} elseif ($requestUri === '') {
				$action = 'frontend';
			} elseif ($requestUri === $config->getSitemapPath()) {
				$action = 'sitemap';
			}
		} else {
			$error = 500;
			header('HTTP/1.1 500 Internal Server Error');
		}
		
		if (!in_array($action, $this->allowedActions, TRUE)) {
			$action = 'error';
			$error = 404;
			header('HTTP/1.1 404 Not Found');
		}
		
		switch ($action) {
			case 'sitemap':
				require $config->getSitemapTemplateFile();
				break;
			case 'frontend':
				require $config->getTemplateFile();
				break;
			case 'error':
				require $config->getErrorTemplateFile();
				break;
		}
	}
	
	/**
	 * Checks whether HTTPs is used.
	 *  
	 * @return bool
	 */
	private function isSecured()
	{
		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
	}
	
	/**
	 * @param Config
	 * @return \DateTime
	 */
	private function getLastUpdate(Config $config)
	{
		return new \DateTime(date('Y-m-d H:i:s', filemtime($config->getTemplateFile())));
	}
}
