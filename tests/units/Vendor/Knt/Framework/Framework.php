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


namespace Knt\Framework\Tests\Units;

use \mageekguy\atoum;

 /**
 * Tests for the Request class.
 * Last version tested: 1.0
 */

class Framework extends atoum\test
{
    /**
     * To test the constructor without parameters.
     * It should initialize the request with $_REQUEST object
     */
    public function testSingleton() {
        
    //Given
    
    //When
        
        $this
            ->object($framework = \Knt\Framework\Framework::getInstance())
                
    //Then
                
                ->isInstanceOf('\Knt\Framework\Framework')
                ->isIdenticalTo(\Knt\Framework\Framework::getInstance())
                
                //We check the request is the default one
                ->object($framework->getRequest())
                    ->isInstanceOf('\Knt\Framework\Core\Request')
                
                //The same with the router
                ->object($framework->getRouter())
                    ->isInstanceOf('\Knt\Framework\Core\Router\AutomatedRouter')
        ;
    }

    /**
     * The singleton instance must be updated when requesting the instance
     * with specific request and/or router
     */
    public function testInstanceIsUpdated() {
        
    //Given
    
        $requestMock = new \mock\Knt\Framework\Core\RequestInterface;
        $routerMock = new \mock\Knt\Framework\Core\Router\RouterInterface;
        
    //When
        
        $this
            ->object($framework = \Knt\Framework\Framework::getInstance())
                
                ->object($framework->getRequest())
                    ->isNotIdenticalTo($requestMock)
                
                ->object($framework->getRouter())
                    ->isNotIdenticalTo($routerMock)
                
            ->object($framework = \Knt\Framework\Framework::getInstance($routerMock, $requestMock))
                
    //Then
                
                ->object($framework->getRequest())
                    ->isIdenticalTo($requestMock)
                
                ->object($framework->getRouter())
                    ->isIdenticalTo($routerMock)
        ;
    }
    
    /**
     * To test the nominal case of handling a request to a view
     */
    public function testHandleView() {
        
    //Given
        
        $request = new \Knt\Framework\Core\Request();
        $request->setMethod(\Knt\Framework\Core\Request::METHOD_GET);
        $request->setQueriedPath('/Hello/Home/index');
    
    //When
        
        ob_start();
        
        $this
            ->when(\Knt\Framework\Framework::handleRequest(null, $request))
                
    //Then
                
            ->string(ob_get_clean())
                ->contains('Say hello')
                
        ;
    }
    
    /**
     * To test the nominal case of handling a request to a controller
     */
    public function testHandleController() {
        
    //Given
        
        $request = new \Knt\Framework\Core\Request();
        $request->setMethod(\Knt\Framework\Core\Request::METHOD_POST);
        $request->setQueriedPath('/Hello/Hello/sayHelloTo');
    
    //When
        
        ob_start();
        
        $this
            ->given(\Knt\Framework\Framework::handleRequest(null, $request))
                
    //Then
                
            ->given($result = ob_get_clean())
            ->boolean((DEBUG_LEVEL > 0 && !empty($result)) || (DEBUG_LEVEL <= 0 && empty($result)))
                ->isTrue()
                                
        ;
    }
    
    /**
     * To test the nominal case of handling a request to a view using a 
     * specific router
     */
    public function testHandleViewWithRouter() {
        
    //Given
        
        $request = new \Knt\Framework\Core\Request();
        $request->setMethod(\Knt\Framework\Core\Request::METHOD_GET);
        $request->setQueriedPath('/HelloWorld');
        
        $request2 = new \Knt\Framework\Core\Request();
        $request2->setMethod(\Knt\Framework\Core\Request::METHOD_GET);
        $request2->setQueriedPath('/HelloWorld2');
        
        $router = new \Knt\Framework\Core\Router\Router();
        $router->addRoute(
            new \Knt\Framework\Core\Router\Route(
                '/HelloWorld',
                '\Hello\Home',
                'index'
            )
        );
        $router->addRoute(
            new \Knt\Framework\Core\Router\Route(
                '/HelloWorld2',
                'Hello\Home',
                'index'
            )
        );
    
    //When
        
        ob_start();
        
        $this
            ->when(\Knt\Framework\Framework::handleRequest($router, $request))
                
    //Then
                
            ->string(ob_get_flush())
                ->contains('Say hello')
                
                
    //When
        
            ->when(\Knt\Framework\Framework::handleRequest($router, $request2))
                
    //Then
                
            ->string(ob_get_clean())
                ->contains('Say hello')
                
        ;
    }
    
    /**
     * A 404 exception should be thrown if trying to handle a non-existent component
     */
    public function test404Exception() {
        
    //Given
        
        $request = new \Knt\Framework\Core\Request();
        $request->setMethod(\Knt\Framework\Core\Request::METHOD_GET);
        $request->setQueriedPath('/None');
    
    //When
        
        $this
            ->exception(
                function() use($request) {
                    \Knt\Framework\Framework::handleRequest(null, $request);
                }
            )
                
    //Then
            ->isInstanceOf('\Knt\Framework\Exception\KntFrameworkException')
            ->hasCode(404)
                    
        ;
    }
    
    /**
     * A 400 exception should be thrown if trying to handle a non-valid component
     */
    public function test400Exception() {
        
    //Given
        
        //We will try to ask for a controller, but using the GET method.
        //That shouldn't work
        $request = new \Knt\Framework\Core\Request();
        $request->setMethod(\Knt\Framework\Core\Request::METHOD_GET);
        $request->setQueriedPath('//Hello/Hello/sayHelloTo');
    
    //When
        
        $this
            ->exception(
                function() use($request) {
                    \Knt\Framework\Framework::handleRequest(null, $request);
                }
            )
                
    //Then
            ->isInstanceOf('\Knt\Framework\Exception\KntFrameworkException')
            ->hasCode(400)
                    
        ;
    }
}