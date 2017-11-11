<?php

if (!function_exists('run')) {
    function run(Tester\TestCase $testCase)
    {
        $testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null);
    }
}
