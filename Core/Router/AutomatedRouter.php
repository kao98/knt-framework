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
 * Description of AutomatedRouter
 *
 * @author Aurelien
 */
class AutomatedRouter extends Router implements AutomatedRouterInterface {
    
    private $_routeClass;
    
    public function __construct($routeClass = '\Knt\Framework\Core\Router\Route') {
        $this->setRouteClass($routeClass);
    }
    
    public function setRouteClass($routeClass) {
        
        if (
            !class_exists($routeClass) || 
            !is_subclass_of($routeClass, 'Knt\Framework\Core\Router\RouteInterface')
            ) {
            
            throw new \InvalidArgumentException('The name of the class is not valid or the specified class doesn\'t implement Knt\Framework\Core\Router\RouteInterface.');
            
        }
        
        $this->_routeClass = $routeClass;
        
    }
    
    public function exists($uri) {
        return $this->search($uri, VIEWS_PATH, VIEWS_EXTENSION);
    }
    
    public function search($uri, $path, $extension) {
        
        if (parent::exists($uri)) {
            return true;
        }
        
        return $this->_search($uri, $path, $extension);

    }

    private function _search($uri, $path, $extension) {
        
        $path = rtrim($path, '\\/');
        
        if (is_dir($path)) {

            $uriParts       = explode('/', trim($uri, '/'));
            $methodName     = array_pop($uriParts);
            $componentName  = implode('/', $uriParts);
            
            if (is_file($path . '/' . $componentName . $extension)) {
                $this->addRoute(new $this->_routeClass($uri, $componentName, $methodName));
                return true;
            }
        
        }
        
        return false;
        
    }
    
}
