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
    \Knt\Framework\Core\CollectionInterface
;

/**
 * ComponentInterface.php
 * 
 * KNT Component interface.
 * Base interface for the components (Views, Controllers, ...).
 * @see \Knt\Framework\Core\Comopnent\Component for more info
 * and a basic implementation of these interface.
 * 
 * @author Aurélien Reeves (Kao ..98)
 */
interface ComponentInterface
{
     
    /**
     * Construct a new component.
     * 
     * @param \Knt\Framework\Framework $frameworkInstance
     * an instance of the knt-framework
     * 
     * @param string $method
     * the name of the component's method to invoke by default
     * 
     * @param \Knt\Framework\Core\CollectionInterface $data
     * some data to pass to the component by default.
     * Those data will be bind to the method arguments, 
     * and available by the component at any time.
     */
    public function __construct(Framework $frameworkInstance, $method, CollectionInterface $data);

    /**
     * The Invoke method should invoke the specified method of the component.
     * If the method has some parameters, we should try to bind them
     * with the component datas.
     * 
     * @param string $method the method of the component to invoke
     */
    public function invoke($method);
    
    /**
     * Set the method of the component to be invoke
     * @param string $method The name of the method to invoke
     * @return \Knt\Framework\Core\Component\Component
     * The current instance of the component (ie. for method chaining).
     */
    public function setMethod($method);

    /**
     * Return the name of the method of the component to be invoke
     * @return string the name of the method to be invoked.
     */
    public function getMethod();

    /**
     * Set the data associated to the component
     * @param \Knt\Framework\Core\CollectionInterface $data
     * the data to associate with the component
     * @return \Knt\Framework\Core\Component\Component
     * the current instance of the componnent (ie. for method chaining)
     */
    public function setData(CollectionInterface $data);

    /**
     * Return the data associated to the component
     * @return \Knt\Framework\Core\CollectionInterface
     * the data associated to the component
     */
    public function getData();
    
 }
