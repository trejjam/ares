<?php
declare(strict_types=1);

$autoloader = require_once dirname(__DIR__) . '/vendor/autoload.php';

define('TEST_DIR', __DIR__);
define('TEMP_DIR', dirname(TEST_DIR) . '/temp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
@mkdir(TEMP_DIR, 0777, TRUE);
Tester\Environment::setup();

define('PHP_INI', 'php.ini-unix');

return $autoloader;
