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
 * Controller.php
 * 
 * KNT Controller class.
 * Base class for the controllers.
 * 
 * A Controller aims to process datas that have been sent to the server
 * using a POST request.
 * 
 * The goal of a controller is to check / filter the input values coming from
 * the client, process them / sending them to models, then
 * responding the client with a view / redirection to a view.
 * 
 * @author Aurélien Reeves (Kao ..98)
 */
class Controller extends Component implements ControllerInterface
{
    
     /**
     * Constructor. Initialize the Controller.
     * 
     * @param Framework\Framework $frameworkInstance an instance of the framework
     * @param string $action the action of the controller to call.
     * @return Controller the current Controller instance 
     */
    public function __construct(Framework $frameworkInstance, $action, CollectionInterface $postedData = null) {
        
        parent::__construct(
            $frameworkInstance, 
            $action, 
            $postedData ?: $frameworkInstance->getRequest()->getPostedData()
        );
        
    }
    
    /**
     * Call the action of the controller by invoking the specified method
     * 
     * @param string $action (default null) the name of the method to invoke.
     * If null, will call the method specified during initialization of the class.
     * @return Controller the current Controller instance
     */
    public function call($action = null) {

        $methodToInvoke = $action ?: $this->getMethod();

        if ($methodToInvoke === null) {
            throw new \Knt\Framework\Exception\KntFrameworkException('No action specified.', 400);
        }
        
        $this->invoke($methodToInvoke);

        return $this;
    }


    public function setPostedData(CollectionInterface $data) {
        
        return $this->setData($data);

    }

    public function getPostedData() {

        return $this->getData();

    }
    
 }
