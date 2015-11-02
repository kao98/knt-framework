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


namespace Knt\Framework\Tests\Units\Core\Router;

use \mageekguy\atoum;

 /**
 * Tests for the Collection class.
 * Last version tested: 1.0
 * 
 * @lastUpdate 2012-11-28
 */

use \Knt\Framework\Core;

class Router extends atoum\test
{
    
    public function testRouter() {
        
    //Given
        $router = new Core\Router\Router;
        
    //When
        $router->addRoute(new Core\Router\Route('sample', 'home', 'index'));
        $router->addRoute(new Core\Router\Route('sample', 'home', 'index'), 'sample-key');        
        
    //Then
        $this
            ->boolean($router->exists('sample'))->isTrue()
            ->boolean($router->exists('sample-key'))->isTrue()
            ->boolean($router->exists('non-route'))->isFalse()
            ->string($router->getRoute('sample')->getComponentName())->isEqualTo('home')
            ->string($router->getRoute('sample-key')->getMethodName())->isEqualTo('index')
            ->string($router->getRoute('sample-key')->getUri())->isEqualTo('sample')
        ;
    }
    
    public function testExceptIfNotExists() {
        
    //Given
        $router = new Core\Router\Router;
        
    //When
        $this
            ->exception(function() use ($router) {$router->getRoute('foo');})
                
    //Then
                
                ->isInstanceOf('\OutOfBoundsException')
                ->hasMessage("No route exists for the uri 'foo'")
        
        ;
    }
    
}
