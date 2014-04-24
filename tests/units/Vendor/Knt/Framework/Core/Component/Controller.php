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


namespace Knt\Framework\Tests\Units\Core\Component;

use \mageekguy\atoum;

 /**
 * Tests for the Controller class.
 * Last version tested: 1.0
 */

use \Knt\Framework\Core;

class Controller extends atoum\test
{
    /**
     * To test the constructor without parameters.
     * It should initialize the request with $_REQUEST object
     */
    public function test__construct() {
        
    //Given
        
        $frameworkMock      = new \mock\Knt\Framework\Framework;
        $requestMock        = new \mock\Knt\Framework\Core\Request;
        $dataCollection     = new Core\Collection;
        $method             = 'method';
        
        $requestMock    ->getMockController()->getPostedData    = $dataCollection;
        $frameworkMock  ->getMockController()->getRequest       = $requestMock;
        
    //When
        
        $component = new Core\Component\Controller (
            $frameworkMock,
            $method
        );
        
    //Then
        
        $this
                
            ->object($component)
                ->isCallable()
                
            ->object($component->getPostedData())
                ->isIdenticalTo($dataCollection)
                
        ;
        
    }

}