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

namespace Knt\Framework\Sample;

class Listener {
    public static function add($controller, $originalRequest = null) {
        $originalRequest = $originalRequest ?: \Knt\Framework\Framework::getInstance()->getRequest();
        
        var_dump($originalRequest);
        
        return '/index.php' . $originalRequest->getQuery();
    }
}

class Home extends \Knt\Framework\Core\Component\View {

    public function index() {
        
        var_dump($this);
        
        echo 'Hello Index!';
        $session = new \Knt\Framework\Core\Session();
        $post = \Knt\Framework\Framework::getInstance()->getRequest()->getPostedData();
        if ($post->get('input') !== null) {
            $session->start();
            
            var_dump($session->set('the_test', $post->get('input')));
            
        } else {
            $session->start();
            var_dump( $session);
        }
        
        echo '
            <a href="/index.php/Sample_1/">Sample #1</a>
            <form method="POST" action="' . Listener::add('Controller/action') . '">
                <input type="text" name="input" value="'.$session->get('the_test', '').'" />
                <input type="submit" />
            </form>';
    }

    public function test($arg1 = 'def', $arg2 = 'default') {
        echo "1:$arg1 2:$arg2";
    }

    
    public function referencedParameter(&$arg) {
        //for unit tests
        return $arg = true;
    }
    
    private function privateMethod() {
        //For some unit tests
        return true;
    }
    
    protected function protectedMethod() {
        //For some unit tests
        return true;
    }
    
}
