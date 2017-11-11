<?php

namespace HtmlDriven\CorsProxyTests\Helpers;

use Tester\Environment as TesterEnvironment;
use Tester\Helpers;

/**
 * Test environment initializer.
 */
final class Environment
{
    /**
     * Setups the test environment.
     *
     * @return void
     */
    public static function setup()
    {
        // configure environment
        TesterEnvironment::setup();
        class_alias('Tester\Assert', 'Assert');
        date_default_timezone_set('UTC');

        // create temporary directory
        $tempId = isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid();
        define('TEMP_DIR', __DIR__ . '/../../tmp/' . $tempId);
        Helpers::purge(TEMP_DIR);

        // reset superglobals
        $_SERVER = array_intersect_key($_SERVER, array_flip([
            'PHP_SELF',
            'SCRIPT_NAME',
            'SERVER_ADDR',
            'SERVER_SOFTWARE',
            'HTTP_HOST',
            'DOCUMENT_ROOT',
            'OS',
            'argc',
            'argv',
            ]));
        $_SERVER['REQUEST_TIME'] = 1234567890;
        $_ENV = $_GET = $_POST = [];

        // load helper functions
        require_once __DIR__ . '/shortcuts.php';
    }
}
