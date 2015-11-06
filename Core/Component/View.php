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
 * View.php
 * 
 * KNT View class.
 * Base class for the views to render
 * 
 * Views are components that display datas to the user.
 * 
 * Inside the knt-framework, views are responsible
 * - to prepare the datas using whatever the developer wants
 *   (templates, direct-to-html, ...)
 * - to render the result (ie. sending the result to the browser)
 * 
 * This base class does not provide any template engine or any helper.
 * This is just the base that provides a render method, method that
 * actually perform a call to another one specified by the user request.
 * 
 * @author Aurélien Reeves (Kao ..98)
 */
class View extends Component implements ViewInterface
{
    
     /**
     * Constructor. Initialize the View.
     * 
     * @param Framework\Framework $frameworkInstance an instance ofthe framework
     * @param string $method (default null) the name of the method to call to render the View.
     * If null the View will be initialized with the VIEWS_INDEX method.
     * @return View the current View instance 
     */
    public function __construct(Framework $frameworkInstance, $method = null, CollectionInterface $queriedData = null) {
        
        parent::__construct(
            $frameworkInstance, 
            $method         ?: VIEWS_INDEX, 
            $queriedData    ?: $frameworkInstance->getRequest()->getQueriedData()
        );
        
    }
    
    /**
     * Render the view: by calling the specified method
     * 
     * @param string $method (default null) the method to call.
     * If null, will call the method specified during initialization of the class.
     * If no method has been specified at all, will try to call the VIEWS_INDEX method.
     * @return View the current View instance
     */
    public function render($method = null) {

        $methodToRender = 
            $method 
            ?: $this->getMethod() 
            ?: VIEWS_INDEX;

        $this->invoke($methodToRender);

        return $this;
    }

    /**
     * Set the data that should be associated with the view.
     * Those datas comes from the user query.
     * @param CollectionInterface $data
     * @return View current instance for method chaining
     */
    public function setQueriedData(CollectionInterface $data) {
        
        return $this->setData($data);

    }

    /**
     * Return the datas associated to the view
     * @return CollectionInterface
     */
    public function getQueriedData() {

        return $this->getData();

    }
    
 }
