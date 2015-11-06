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

namespace Knt\Framework\Sample\HelloTwig;

require_once(__DIR__ . '/twig/Twig-1.23.1/lib/Twig/Autoloader.php');

/**
 * Description of Home
 *
 * @author Aurelien
 */
class BaseView extends \Knt\Framework\Core\Component\View {

        protected $twig = null;
        private $twigTemplate = null;
        private $twigData = null;
    
        public function __construct(
            \Knt\Framework\Framework $frameworkInstance,
            $method = null,
            \Knt\Framework\Core\CollectionInterface $queriedData = null
        ) {
            
            parent::__construct($frameworkInstance, $method, $queriedData);

            \Twig_Autoloader::register();

            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/twig/templates');
            $this->twig = new \Twig_Environment($loader, array(
                'cache' => __DIR__ . '/twig/templates/cache',
            ));
            
            $this->twigData = array();
        }

        public function render($method = null) {
            parent::render($method);
            
            if ($this->twigTemplate) {
                echo $this->twigTemplate->render($this->getTwigData());
            }
        }
        
        public function loadTemplate($template) {
            $this->twigTemplate = $this->twig->loadTemplate($template);
        }
        
        public function addToTwig($dataKey, $dataValue) {
            $this->twigData[$dataKey] = $dataValue;
        }
        
        public function getTwigData() {
            return $this->twigData;
        }
}
