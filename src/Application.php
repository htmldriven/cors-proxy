<?php

namespace HtmlDriven\CorsProxy;

use DateTime;
use Dibi\Connection as DibiConnection;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use HtmlDriven\CorsProxy\Config;
use HtmlDriven\CorsProxy\Exception\FileNotFoundException;
use HtmlDriven\CorsProxy\Exception\MalformedConfigFileException;
use PDO;
use RuntimeException;

/**
 * Main application entry point.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Application
{
    /** @var string */
    const VERSION = '1.4.0';

    /** @var string */
    const DEFAULT_DOMAIN = 'cors-proxy.htmldriven.com';

    /** @var array */
    public $configDefaults = [];

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
    public function __construct(Config $config = null)
    {
        $this->configDefaults = $this->createConfigDefaults();
        $this->config = ($config === null ? $this->createConfig() : $config);
    }

    /**
     * Handles the request.
     *
     * @return void
     * @throws MalformedConfigFileException If configuration file parsing fails.
     * @throws FileNotFoundException If template file does not exist.
     * @throws RuntimeException If HTTP method cannot be detected.
     */
    public function run()
    {
        $config = $this->config;

        // handle CORS proxy request if URL is set
        if (isset($_GET[$config->getUrlParameterName()])) {
            if ($config->isEnabled()) {
                $url = (string) $_GET[$config->getUrlParameterName()];

                $client = $this->createClient($config);

                $dibiConnection = $this->createDibiConnection($config);

                $requestHandler = new RequestHandler(
                    $config,
                    $client,
                    $dibiConnection
                );

                $dibiConnection->disconnect();

                $method = $this->detectHttpMethod();

                $requestHandler->handleRequest($method, $url);
            } else {
                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
                header($protocol . ' ' . 404 . ' Not Found');
                echo 'Service has been disabled';
            }
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
            if (false === ($iniConfig = parse_ini_file($iniFile, true))) {
                throw new MalformedConfigFileException(sprintf("Unable to parse configuration file '%s'.", $iniFile));
            }
            $config = array_replace_recursive($this->configDefaults, $iniConfig);
        } else {
            $config = $this->configDefaults;
        }

        date_default_timezone_set($config['timezone']);

        // absolutize filepaths
        $config['templateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['templateFile']);
        $config['sitemapTemplateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['sitemapTemplateFile']);
        $config['errorTemplateFile'] = Helpers::absolutizeFilepath(__DIR__, $config['errorTemplateFile']);

        return new Config(
            $config['enabled'],
            $config['urlParameterName'],
            $config['userAgent'],
            $config['templateFile'],
            $config['sitemapPath'],
            $config['sitemapTemplateFile'],
            $config['errorTemplateFile'],
            $config['database'],
            $config['requestLogEnabled']
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
     * @return DibiConnection
     */
    private function createDibiConnection(Config $config)
    {
        $dibiConnection = new DibiConnection(
            $config->getDatabaseConfig()
        );
        return $dibiConnection;
    }

    /**
     * Detects HTTP method from global server params.
     *
     * @return string
     * @throws RuntimeException If HTTP method cannot be detected.
     */
    private function detectHttpMethod()
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new RuntimeException('Unable to detect HTTP method.');
        }
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param Config
     * @return void
     */
    private function showFrontEnd(Config $config)
    {
        $isServiceEnabled = $config->isEnabled();

        $isSecured = $this->isSecured();
        $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : static::DEFAULT_DOMAIN;
        $protocol = ($isSecured ? 'https' : 'http');
        $domainUrl = $protocol . '://' . $domain;
        $basePath = '';

        $lastUpdate = $this->getLastUpdate($config);

        $action = null;

        $error = null;

        $requestUri = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : null;
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

        if (!in_array($action, $this->allowedActions, true)) {
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
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    }

    /**
     * @param Config
     * @return DateTime
     */
    private function getLastUpdate(Config $config)
    {
        return new DateTime(date('Y-m-d H:i:s', filemtime($config->getTemplateFile())));
    }

    /**
     * @return array
     */
    private function createConfigDefaults()
    {
        return [
            'enabled' => true,
            'urlParameterName' => 'url',
            'userAgent' => 'htmldriven/cors-proxy ' . static::VERSION,
            'templateFile' => __DIR__ . '/../app/templates/default/frontend.phtml',
            'sitemapPath' => '/sitemap.xml',
            'sitemapTemplateFile' => __DIR__ . '/../app/templates/default/sitemap.pxml',
            'errorTemplateFile' => __DIR__ . '/../app/templates/default/error.phtml',
            'timezone' => 'UTC',
            'database' => [
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=cors_proxy;host=' . $this->detectMySqlHost() . ';charset=utf8mb4',
                'username' => 'cors_proxy',
                'password' => '',
                'lazy' => true,
                'timezone' => '+00:00',
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+00:00\'',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ],
            ],
            'requestLogEnabled' => false,
        ];
    }

    /**
     * Detects MySQL host.
     *
     * @return string
     */
    private function detectMySqlHost()
    {
        $host = getenv('_MYSQL_HOST');
        if ($host === false) {
            $host = '127.0.0.1';
        }
        return $host;
    }
}
