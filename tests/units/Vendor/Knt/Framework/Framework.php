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
}