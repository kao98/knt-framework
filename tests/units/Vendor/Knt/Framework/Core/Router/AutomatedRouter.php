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

use \Knt\Framework\Core\Router;

class AutomatedRouter extends atoum\test
{
    
    public function testSearchExistingRoute() {
        
    //Given
        $router = new Router\AutomatedRouter;
        
    //When
    
        $router->addRoute(new Router\Route('test', '_', '_'));
        
    //Then
        $this
            ->boolean($router->search('test'))->isTrue()
        ;
    }
    
    public function testAutomaticalySearch() {
        
    //Given
        $router = new Router\AutomatedRouter;
        
    //When
        
    //Then
        $this
                
            //Automaticaly look for views
            ->boolean($router->search('/', VIEWS_PATH, VIEWS_EXTENSION, ['SEARCH_VIEW' => true]))->isTrue()
            ->boolean($router->search('/Home', VIEWS_PATH, VIEWS_EXTENSION, ['SEARCH_VIEW' => true]))->isTrue()
            ->boolean($router->search('/Home/index', VIEWS_PATH, VIEWS_EXTENSION, ['SEARCH_VIEW' => true]))->isTrue()
            ->boolean($router->search('/Home/index', VIEWS_PATH))->isTrue()
                
            //Automatically look for controllers
            ->boolean($router->search('/Hello/Hello/sayHelloTo', CONTROLLERS_PATH))->isTrue()
            ->boolean($router->search('/Hello/Hello/', CONTROLLERS_PATH))->isFalse()
                
        ;
    }
    
    public function testExceptIfNoPath() {
        
    //Given
        $router = new Router\AutomatedRouter;
        
    //When
        $this
            ->exception(function() use ($router) {$router->search('foo');})
                
    //Then
                
                ->isInstanceOf('\InvalidArgumentException')
                ->hasMessage("To automaticaly look for routes, you must specify a valid path.")
        
        ;
    }
    
    public function testExceptIfBadRouteClass() {
        
    //Given
        $router = new Router\AutomatedRouter;
        
    //When
        $this
            ->exception(function() use ($router) {$router->setRouteClass('\Knt\Framework');})
                
    //Then
                
                ->isInstanceOf('\InvalidArgumentException')
                ->hasMessage("The name of the class is not valid or the specified class doesn't implement Knt\Framework\Core\Router\RouteInterface.")
        
        ;
    }
    
    public function testRouteClass() {
        
    //Given
        $router = new Router\AutomatedRouter;
        
    //When
        $this
            ->when($router->setRouteClass('\mock\Knt\Framework\Core\Router\Route'))
            ->and($router->search('/Home/index', VIEWS_PATH))
                
    //Then
            ->object($router->getRoute('/Home/index'))
                ->isInstanceOf('\mock\Knt\Framework\Core\Router\Route')
        
        ;
    }
        
}
