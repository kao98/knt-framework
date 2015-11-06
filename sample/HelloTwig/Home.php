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

namespace Knt\Framework\Sample\HelloTwig;

/**
 * Description of Home
 *
 * @author Aurelien
 */
class Home extends \Knt\Framework\Sample\HelloTwig\BaseView
{

    public function index() {
        $this->loadTemplate('home.index.html.twig');
    }
    
    public function hello($name) {
        $this->loadTemplate('home.hello.html.twig');
        $this->addToTwig('name', $name);
    }
    
}
