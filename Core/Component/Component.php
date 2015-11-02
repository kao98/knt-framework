<?php

/* 
 * knt-framework
 * Another php micro-framework (http://www.kaonet-fr.net/framework)
 * 
 * Licensed under The MIT License
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * @link    http://www.kaonet-fr.net/framework
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace Knt\Framework\Core\Component;

use
    \Knt\Framework\Framework,
    \Knt\Framework\Exception,
    \Knt\Framework\Core\CollectionInterface
;

/**
 * Component.php
 * 
 * KNT Component class.
 * Base class for the components (Views, Controllers, ...).
 * A component define a method, and some data mapped to it.
 * The specified method makes the component callable.
 * 
 * From the framework point-of-view, a request will be mapped to a component.
 * 
 * When the user will ask for the component /Foo/bar, the inherited class
 * Foo will be callable, the called function being Foo::bar().
 * 
 * @author Aurélien Reeves (Kao ..98)
 */
class Component implements ComponentInterface
{

    private $_framework = null; //an instance of the framework
    private $_method    = null; //the method of the component to be called
    private $_data      = null; //some data passed to the component

    /**
     * Construct a new component.
     * 
     * @param \Knt\Framework\Framework $frameworkInstance
     * an instance of the framework
     * 
     * @param string $method the name of the component's method to call
     * 
     * @param \Knt\Framework\Core\CollectionInterface $data
     * some data to pass to the component.
     * Those data will be bind to the method arguments, 
     * and available by the component at any time.
     */
    public function __construct(
        Framework $frameworkInstance,
        $method,
        CollectionInterface $data
    ) {
        
        $this->_framework = $frameworkInstance;
        
        $this
            ->setData   ($data)
            ->setMethod ($method)
        ;
        
    }
    
    /**
     * Invoke the specified method of the current component.
     * If the method has some parameters, we will try to bind them
     * with the component datas.
     * 
     * @param string $method the method of the component to invoke
     * 
     * @throws \Knt\Framework\Exception\KntFrameworkException
     * An exception is thrown while trying to invoke a method
     * that doesn't exists, is not publicly callable, or
     * with some parameters that cannot be safely bind because they couldn't be
     * bind by value.
     */
    public function invoke($method) {

        if (!method_exists($this, $method)) {
            
            throw new Exception\KntFrameworkException(
                sprintf(
                    "Component '%s' has no method '%s'",
                    get_class($this),
                    $method
                )
            );
            
        }
        
        $reflection = new \ReflectionMethod($this, $method);

        if (!$reflection->isPublic() || $reflection->isAbstract()) {
            
            throw new Exception\KntFrameworkException(
                sprintf("You are not authorized to call %s::%s", get_class($this), $method)
            );

        }

        $reflection->invokeArgs($this, $this->_bind($reflection));

    }

    /**
     * Bind the parameter of the given reflection method
     * with the values retrieved from the data of the component.
     * @param \ReflectionMethod $reflection
     * @return array
     * @throws Exception\KntFrameworkException
     */
    private function _bind(\ReflectionMethod $reflection) {
        
        $arguments  = array();
        $parameters = $reflection->getParameters();

        foreach ($parameters as $parameter) {

            //In theory, the datas are not php vars declared in the code,
            //but name/value pairs comming from a HTTP request.
            //We don't have any usable references so we make sure we will be
            //able to pass the parameters by value.
            if (!$parameter->canBePassedByValue()) {
                throw new Exception\KntFrameworkException("{$parameter->getName()} cannot be passed by reference");
            }

            $argument = $this->getData()->get($parameter->getName(), null);
            
            if ($argument === null && $parameter->isDefaultValueAvailable()) {
                $argument = $parameter->getDefaultValue();
            }

            $arguments[] = $argument;

        }
        
        return $arguments;
    }
    
    /**
     * The magic :p
     * This method make the component callable.
     * @param string $method
     * The name of the method to invoke. Default null. If not specified,
     * we will try to invoke the method previously setted using
     * the constructor or the method setMehod().
     * @throws \Knt\Framework\Exception\KntFrameworkException
     * thrown if not method to invoke has been specified.
     * Also, see the method 'invoke'.
     */
    public function __invoke($method = null) {
        
        if ($method === null && $this->getMethod() === null) {
            throw new Exception\KntFrameworkException('Method to invoke is missing.');
        }
        
        $this->invoke($method ?: $this->getMethod());
        
    }
    
    /**
     * Set the method of the component to be invoke
     * @param string $method The name of the method to call
     * @return \Knt\Framework\Core\Component\Component
     * The current instance of the component (ie. for method chaining).
     */
    public function setMethod($method) {

        $this->_method = $method;
        return $this;

    }

    /**
     * Return the name of the method of the component to be invoke
     * @return string the name of the method to be invoked.
     */
    public function getMethod() {

        return $this->_method;

    }

    /**
     * Set the data associated to the component
     * @param \Knt\Framework\Core\CollectionInterface $data
     * the data to associate with the component
     * @return \Knt\Framework\Core\Component\Component
     * the current instance of the componnent (ie. for method chaining)
     */
    public function setData(CollectionInterface $data) {
        
        $this->_data = $data;
        return $this;

    }

    /**
     * Return the data associated to the component
     * @return \Knt\Framework\Core\CollectionInterface
     * the data associated to the component
     */
    public function getData() {

        return $this->_data;

    }
    
 }
