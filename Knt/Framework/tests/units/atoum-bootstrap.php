<?php

DEFINED('BASE_PATH') OR DEFINE('BASE_PATH', __DIR__ . '/../../');

require_once(BASE_PATH . 'tests/units/mageekguy.atoum.phar');
require_once(BASE_PATH . 'Config/const.php');
require_once(BASE_PATH . 'Go.php');

set_include_path(get_include_path() . PATH_SEPARATOR . BASE_PATH . '../..');
spl_autoload_register('Knt::psr0_classLoader');
