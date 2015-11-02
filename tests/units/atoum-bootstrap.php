<?php

DEFINED('BASE_PATH') OR DEFINE('BASE_PATH', __DIR__ . '/../../');

require_once(BASE_PATH . 'tests/units/atoum.phar');
require_once(BASE_PATH . 'Config/const.php');

spl_autoload_register(function ($className) {

    if (strpos($className, 'Knt\Framework') === false) {
        return false;
    }
    
    if (strpos($className, 'Tests\Units') !== false) {
        return false;
    }

    $fileName = 
        BASE_PATH
        .str_replace('\\', '/',
            str_replace('Knt\Framework', '', $className)
        )
        .'.php'
    ;

    if (file_exists($fileName)) {
        require $fileName;
        return  true;
    }

    return false;

});