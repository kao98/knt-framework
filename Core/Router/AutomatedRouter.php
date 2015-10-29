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
        
    public function search($uri, $path, $extension, array $options = []) {
        
        if (parent::exists($uri)) {
            return true;
        }
        
        return $this->_search($uri, $path, $extension, $options);

    }

    private function _search($uri, $path, $extension, $options) {
        
        $exists = function($value) use ($uri, $path, $extension) {
            $path = rtrim($path, '\\/');

            if (is_dir($path)) {

                $uriParts       = explode('/', trim($value, '/'));
                $methodName     = array_pop($uriParts);
                $componentName  = implode('/', $uriParts);

                if (is_file($path . '/' . $componentName . $extension)) {
                    $this->addRoute(new $this->_routeClass($value, $componentName, $methodName), $uri);
                    return true;
                }

            }
            
            return false;
        };
        
        $uri = rtrim($uri, '\\/');
        
        if (array_key_exists('SEARCH_VIEW', $options) && $options['SEARCH_VIEW'] === true) {

            $uri1   = $uri . '/' . VIEWS_INDEX;
            $uri2   = $uri . '/' . DEFAULT_VIEW . '/' . VIEWS_INDEX;

            return $exists($uri) || $exists($uri1) || $exists($uri2);
        }
        
        return $exists($uri);
    }
    
}
