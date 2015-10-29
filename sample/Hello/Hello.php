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

namespace Knt\Framework\Sample\Hello;

/**
 * Description of Hello
 *
 * @author areeves
 */
class Hello extends \Knt\Framework\Core\Component\Controller {
    
    public function sayHelloTo($name) {
        header('location: /Hello/Home/hello?name=' . $name);
    }
    
}
