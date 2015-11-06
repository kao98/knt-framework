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
    \Knt\Framework\Core\CollectionInterface
;

/**
 * ControllerInterface.php
 * 
 * KNT Controller interface.
 * Base interface for the controllers.
 * 
 * A Controller aims to process datas that have been sent to the server
 * using a POST request.
 * 
 * The goal of a controller is to check / filter the input values coming from
 * the client, process them / sending them to models, then
 * responding the client with a view / redirection to a view.
 * 
 * The interface defines the methods that must be available by controllers.
 * 
 * @author Aurélien Reeves (Kao ..98)
 */
interface ControllerInterface extends ComponentInterface
{
    /**
     * The call method must process the request that redirected to this
     * controller by calling the specified action.
     * Ideally it calls a method of the class to perform the action.
     * @param type $action
     */
    public function call($action = null);

    /**
     * This method set the 'data' property.
     * Datas will then be used to precess the request's action.
     * @param CollectionInterface $data
     */
    public function setPostedData(CollectionInterface $data);

    /**
     * Return the data associated to the controller.
     * @return CollectionInterface
     */
    public function getPostedData();
}