<?php

/* 
 * knt-cms: another Content Management System (http://www.kaonet-fr.net/cms)
 * 
 * Licensed under The MIT License
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * @link          http://www.kaonet-fr.net/cms
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//require 'Vendor/Knt/Framework/Framework.php';

//use \Knt\Framework\Framework;


/**
 * Go.php
 * 
 * KNT Framework launcher (a kind of bootstrap file).
 * 
 * Version 1.0: Initial version
 * 
 * @version 1.0
 * @author Aurélien Reeves (Kao ..98)
 */
class Knt
{
    
    /**
     * Knt::Go is a kind of entry point for the Knt Framework.
     * Simply call Knt::Go() to handle your request.
     * 
     * It will register a basic autoloader used by the framework (PSR-0 compliant).
     * The root folder for the autoloader is the folder that contains
     * the Knt base folder (by default, the 'Vendor' folder). So if you follow
     * the PSR-0 rules to name your classes, you won't have to register
     * anything more to autoload your functions.
     * 
     * If you follow PSR-0 rules but your files are in another location,
     * simply use "set_include_path" to include your location in the include path.
     * 
     * If you wan't to register your own autoloader, feel free. That shouldn't break
     * the one used by the framework. But do it before calling Knt::Go().
     */
    public static function Go() {
        
        //Do we need an autoloader?
        if (!class_exists('\Knt\Framework\Framework', true)) {
            //Yes, this is a basic test, maybe the component factory has been
            //included manualy, but for now, this is enough. 
            //So yes, we need an autoloader.

            spl_autoload_register(function ($className) {

                if (strpos($className, 'Knt\Framework') === false) {
                    return false;
                }

                $fileName = 
                    __DIR__
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

        }
        
        \Knt\Framework\Framework::handleRequest();

    }
    
}