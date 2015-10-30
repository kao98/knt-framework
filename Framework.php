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

namespace Knt\Framework;

/* Configuration uses constants defined in Config/const.php */

require_once 'Config/const.php';

/* Ok, we can continue with the required files inclusion, the uses of the required namespaces, and everything */

use 
    \Knt\Framework\Core\RequestInterface,
    \Knt\Framework\Core\Router
;

/**
 * Framework.php
 * Creation date: 27 nov. 2012
 * 
 * KNT Framework main class.
 * It provide the static HandleRequest method that initialize the
 * framework and handle the client request.
 * 
 * Version 1.0: Initial version
 *
 * @package Knt\Framework
 * @version 1.0
 * @author Aurélien Reeves (Kao ..98)
 */
class Framework
{
    
    const COMPONENT_TYPE_VIEW       = 'view';
    const COMPONENT_TYPE_CONTROLLER = 'controller';
    const COMPONENT_TYPE_REST       = 'rest';


    protected static    $_instance  = null; //Singleton instance
    protected           $_request   = null; //The request instance
    protected           $_router   = null; //The router associated to the framework

    /**
     * Constructor. Initialize a new instance of the Framework with the given Request object.
     * 
     * @param RequestInterface $request The request that will be handled by the framework. Default null.
     * If null, the handled request will be initialize with some default values.
     */
    private function __construct(Router\RouterInterface $router = null, RequestInterface $request = null) {

        $this
            ->setRequest($request)
            ->setRouter($router)
        ;

    }

    /**
     * static class: no clone.
     */
    private function __clone() { }
        
    /**
     * Singleton implementation: return the Framework instance.
     * Initialize / set the request of the Framework instance with the given request object.
     * Initialize / set the router of the Framework instance with the given router object.
     * 
     * @param Router\RouterInterface $router (default null) A router to use with the framework.
     * If null, and no instance of the framework exists,
     * a new instance will be initialized with a new default Router object.
     * @param RequestInterface $request (default null) A request wich will be passed to the Framework instance.
     * If null, and no instance of a Framework exists, 
     * the instance will be initialized with a new default Request object.
     * @return Framework the singleton instance 
     */
    public static function getInstance(Router\RouterInterface $router = null, RequestInterface $request = null) {
        
        if (self::$_instance !== null) {
            if ($request !== null) {
                self::$_instance->setRequest($request);
            }
            if ($router !== null) {
                self::$_instance->setRouter($router);
            }
        }
        
        return self::$_instance 
            ?: self::$_instance = new Framework($router, $request);
        
    }
    
    /**
     * This static method will handle the given request. It will initialize a new
     * instance of the Framework, find then execute the requested method.
     *
     * @param RequestInterface $request The request to handle. Default null. If null, will initialize
     * a new default Request object.
     * @return Framework The instancied Framework instance.
     */
    public static function handleRequest(Router\RouterInterface $router = null, RequestInterface $request = null) {
        
        if (DEBUG_LEVEL > 0) {
            $startingTime = microtime(true); //TODO: refactor that
        }
        
        $instance = self::getInstance($router, $request);
        
        if (RequestInterface::METHOD_GET === $instance->request->getMethod()) {
            
            $instance
                ->loadComponent()
                ->render()
            ;
            
        } else {
            
            $instance
                ->loadComponent(self::COMPONENT_TYPE_CONTROLLER)
                ->call()
            ;
            //TODO: retrieve the view from the controller just called then render it
        }
        
        if (DEBUG_LEVEL > 0) {
            echo '<br /><pre>' . round((microtime(true) - $startingTime) * 1000, 3) . 'ms</pre>';
            //TODO: refactor that
        }
        
    }

    /**
     * Retrieve a route that lead to a component
     * that can handle the given query.
     * This is usefull when used with an 'automated' router.
     * @see Router\Router for more informations about routers and 'automated' routers
     * @param string $query a query string that ask for a component
     * @param string $componentType the type of the component we are looking for (usefull with 'automated' routers)
     * @return string the URI of one route that lead to a component ready to process the query.
     * @throws Exception\KntFrameworkException 404 if no route can be found.
     */
    public function retrieveRouteUri($query, $componentType = self::COMPONENT_TYPE_VIEW) {
        
        $router = $this->getRouter();
        
        //Caution: this basic call is required with a non-automated (static) router
        if ($router->exists($query)) {
            return $query;
        }
        
        if (is_subclass_of($router, 'Knt\Framework\Core\Router\AutomatedRouterInterface')) {
            $path = VIEWS_PATH;
            $extension = VIEWS_EXTENSION;
            $options = ['SEARCH_VIEW' => true];

            if ($componentType === self::COMPONENT_TYPE_CONTROLLER) {
                $path = CONTROLLERS_PATH;
                $extension = CONTROLLERS_EXTENSION;
                $options = [];
            }

            if ($router->search($query, $path, $extension, $options)) {
                return $query;
            }   
        }

        //Ok. Surrender :-(
        throw new Exception\KntFrameworkException(
            sprintf('%s cannot be Found', $query),
            404
        );
    }
    
    /**
     * Load a component given it's type and a query
     * @param string $componentType (default self::COMPONENT_TYPE_VIEW) type of the component.
     * Can be self::COMPONENT_TYPE_VIEW, or self::COMPONENT_TYPE_CONTROLLER.
     * @param string $query (default null) a query resulting in a component.
     * If null, will get the request for the curent framework instance.
     * @return \Knt\Framework\Core\Component\*Interface an instance implementing a component interface
     * @throws Exception\KntFrameworkException 
     * 404 if no route to the component can be found
     * 400 if a the component has been queried in a wrong way, or the query don't match to a valid component.
     */
    public function loadComponent($componentType = self::COMPONENT_TYPE_VIEW, $query = null) {
        
        if (!$query) {
            $query = $this
                ->getRequest()
                ->getQueriedPath()
            ;
        }
        
        $routeUri   = $this->retrieveRouteUri($query, $componentType);
        $route      = $this->getRouter()->getRoute($routeUri);
        $class      = $this->getProjectNamespace() . strtr(trim($route->getComponentName(), '\\/'), '/', '\\');
        $interface  = 'Knt\Framework\Core\Component\\' . ucfirst($componentType) . 'Interface';
        
        $path       = $componentType === self::COMPONENT_TYPE_CONTROLLER ? CONTROLLERS_PATH : VIEWS_PATH;
        $extension  = $componentType === self::COMPONENT_TYPE_CONTROLLER ? CONTROLLERS_EXTENSION : VIEWS_EXTENSION;
        
        //Components may not respond to PSR-0 naming conventions so
        //we require it manually
        require_once ($path . '/' . $route->getComponentName() . $extension);
        
        if (is_subclass_of("$class", $interface)) {
            return new $class($this, $route->getMethodName());
        }
        
        throw new Exception\KntFrameworkException('Bad request.', 400);
    }
    
    /**
     * Return a formated version of the PROJECT_NAMESPACE ready to be used.
     * These method ensure that PROJECT_NAMESPACE starts and ends with one and
     * only one back-slash.
     * @return string
     */
    protected function getProjectNamespace() {
        return sprintf("\\%s\\", trim(PROJECT_NAMESPACE, '\\/'));
    }
    
    /**
     * Return the router of the current Framework object
     *
     * @return Router\RouterInterface The router corresponding to the current Framework instance
     */
    public function getRouter() {
        
        return $this->_router;
    
    }

    /**
     * Set the router for the current Framework instance
     * 
     * @param Router\RouterInterface $router (default null) the router instance. If null, will initialize a default router. 
     */
    public function setRouter(Router\RouterInterface $router = null) {
        
        if ($router == null) {

            $this->_router = new Router\AutomatedRouter;
        
        } else {
        
            $this->_router = $router;
        
        }
        
        return $this;
        
    }
    
    /**
     * Return the request object of the current Framework object
     *
     * @return RequestInterface The request corresponding to the current Framework instance
     */
    public function getRequest() {
        
        return $this->_request;
    
    }

    /**
     * Set the request for the current Framework instance
     * 
     * @param RequestInterface $request (default null) the request object. If null, will initialize a default request. 
     */
    public function setRequest(RequestInterface $request = null) {
        
        if ($request == null) {

            $this->_request = new Core\Request();
        
        } else {
        
            $this->_request = $request;
        
        }
        
        return $this;
        
    }
    
    /**
     * The magic __get method allow to ask for some properties in usual names
     * like the GET and POST data which are stored in the Request object.
     * 
     * @param string $variableName the name of the desired property
     * @return mixed the requested property 
     */
    public function __get($variableName) {
        
        switch ($variableName) {
            case 'queriedData':
            case 'query':
            case 'get':
                return $this->getRequest()->getQueriedData();
            
            case 'postedData':
            case 'data':
            case 'post':
                return $this->getRequest()->getPostedData();
            
            case 'queriedPath':
            case 'path':
                return $this->getRequest()->getQueriedPath();
    
            case 'request':
                return $this->getRequest();
            
        }
        
    }
    
}
