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

namespace Knt\Framework\Core\Router;

/**
 * Description of Router
 *
 * @author Aurelien
 */
class Router implements RouterInterface {
    
    private $_routes    = array();
    
    public function addRoute(RouteInterface $route, $key = null) {
        $this->_routes[$key ?: $route->getUri()] = $route;
    }
    
    public function exists($uri) {
        
        if (array_key_exists($uri, $this->_routes)) {
            return true;
        } 
        
        return false;
        
    }
    
    public function getRoute($uri) {
        
        if (!$this->exists($uri)) {
            throw new \OutOfBoundsException("No route exists for the uri '$uri'");
        }
        return $this->_routes[$uri];
        
    }
    
}
