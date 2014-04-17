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

namespace Knt\Framework\Core\Routeur;

/**
 *
 * @author Aurelien
 */
interface RouteurInterface {
    //put your code here
    public function addRoute(RouteInterface $route);
    public function getRoute($uri);
    public function exists($uri);
    
}