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
 * Tests for the Request class.
 * Last version tested: 1.0
 */

use \Knt\Framework\Core;

define('SAMPLE_PATH', BASE_PATH . '/Vendor/Knt/Framework/Sample');

class Component extends atoum\test
{
    /**
     * Test the constructor and the accessors of the Component class
     */
    public function test__construct() {
        
    //Given
        
        $frameworkMock      = new \mock\Knt\Framework\Framework;
        $dataCollection     = new Core\Collection;
        $method             = 'method';
        
    //When
        
        $component = new Core\Component\Component(
            $frameworkMock,
            $method,
            $dataCollection
        );
        
    //Then
        
        $this
                
            ->object($component)
                ->isCallable()
                
            ->string($component->getMethod())
                ->isEqualTo($method)
                
            ->object($component->getData())
                ->isIdenticalTo($dataCollection)
                
        ;
        
    }
    
    /**
     * Test method chaining
     */
    public function testMethodChaining() {
        
    //Given
        
        $frameworkMock      = new \mock\Knt\Framework\Framework;
        $dataCollection     = new Core\Collection;
        $method             = 'method';
        
    //When
        
        $component = new Core\Component\Component($frameworkMock, null, new Core\Collection);
        $component
            ->setData   ($dataCollection)
            ->setMethod ($method)
        ;
        
    //Then
        
        $this

            ->string($component->getMethod())
                ->isEqualTo($method)
                
            ->object($component->getData())
                ->isIdenticalTo($dataCollection)
                
        ;
        
    }
    
    /**
     * Test the Invoke method throw an exception if no method to invoke
     */
    public function testInvokeExceptIfMethodDontExists() {
        
    //Given
        
        $frameworkMock  = new \mock\Knt\Framework\Framework;
        $collectionMock = new \mock\Knt\Framework\Core\Collection;
        
        $component      = new Core\Component\Component(
            $frameworkMock, 
            'method', 
            $collectionMock
        );
        
    //When
        $this
            ->exception(
                function() use($component) {
                    $component->invoke('method');
                }
            )
                    
    //Then
                ->hasMessage("Component 'Knt\Framework\Core\Component\Component' has no method 'method'")
                    
        ;
    }
    
    /**
     * Test the Invoke method throw an exception if method null
     */
    public function testInvokeExceptIfNullMethod() {
        
    //Given
        
        $frameworkMock  = new \mock\Knt\Framework\Framework;
        $collectionMock = new \mock\Knt\Framework\Core\Collection;
        
        $component      = new Core\Component\Component(
            $frameworkMock, 
            'method', 
            $collectionMock
        );
        
    //When
        $this
            ->exception(
                function() use($component) {
                    $component->setMethod(null);
                    $component();
                }
            )
                
    //Then
                
                ->hasMessage("Method to invoke is missing.")
                    
        ;
        
    }
    
    /**
     * Test the nominal use of the Invoke method.
     */
    public function testInvokeAndCallableNominalUse() {
        
    //Given
        
        $emptyCollection    = new Core\Collection();
        $parameters         = array('method' => 'setData', 'data' => $emptyCollection);
        $frameworkMock      = new \mock\Knt\Framework\Framework;
        $collection         = new \Knt\Framework\Core\Collection($parameters);
        
        $component = new Core\Component\Component(
            $frameworkMock,
            'setMethod',
            $collection
        );
        
        //We will invoke the setMethod method that will update the method
        //from 'setMethod' to 'getData'.
        
    //When
        
        //'regular' invoke call: will set the method to 'setData'
        $component->invoke('setMethod');
        
        //'magic' call. The method has been set to 'setData', so now we will set
        //the data with the empty collection as it is in the $parameters array.
        $component();
        
    //Then
        
        $this
            ->string($component->getMethod())
                ->isEqualTo('setData')
                
            ->object($component->getData())
                ->isIdenticalTo($emptyCollection)
        
        ;
        
    }
    
}