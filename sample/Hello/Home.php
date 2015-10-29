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
 * Description of Home
 *
 * @author Aurelien
 */
class Home extends \Knt\Framework\Sample\Hello\BaseView {

    public function index() {
        echo ""
            . "<form method='post' action='Hello/Hello/sayHelloTo'>"
                . "<p>Say hello to: "
                . "<input type='text' name='name' value='World' />"
                . "<input type='submit'>"
            . "</form>";
    }
    
    public function hello($name) {
        echo "Hello $name!";
    }
    
}
