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

namespace Knt\Framework;

/*
 * This file contains all global constants used to configure / customize the
 * framework.
 * 
 * Those constants are used mainly to define the path where to find
 * things like components (views, controllers).
 */

/**
 * BASE_PATH help to retrieve the root path of the application.
 * You may customize this constant to define where to locate your application.
 * 
 * Example:
 * For the following project directory structure, you could set
 * BASE_PATH to `the-project/app`.
 * <pre>
 * the-project
 *   vendor
 *     knt
 *       framework
 *     {...}
 *   app
 *     views
 *     controllers
 *     models
 * </pre>
 * 
 * Note:
 * - By default, BASE_PATH is used to define VIEWS_PATH and CONTROLLERS_PATH
 *   so altering BASE_PATH will impact VIEWS_PATH and CONTROLLERS_PATH.
 * - BASE_PATH is used only to define VIEWS_PATH and CONTROLLERS_PATH so
 *   if you manage yourself those constants, feel free to use BASE_PATH for
 *   whatever you want.
 * - By default, it points to the folder that contains the Framework.php file.
 */
DEFINED('BASE_PATH')        OR DEFINE('BASE_PATH',          __DIR__ . '/..');

/**
 * FRAMEWORK_PATH help to retrieve the knt-framework.
 * You should use this constant to define where to locate the framework.
 * It should point to the folder containing the Framework.php file.
 * 
 * Example:
 * For the following project directory structure, you could set
 * FRAMEWORK_PATH should point to `the-project/vendor/knt/framework`.
 * <pre>
 * the-project
 *   vendor
 *     knt
 *       framework
 *         Framework.php
 *     {...}
 *   app
 *     views
 *     controllers
 *     models
 * </pre>
 * 
 * Note:
 * - By default, FRAMEWORK_PATH is defined relatively to this file, so
 *   it should always be correct by default and should not be defined elsewhere.
 */
DEFINED('FRAMEWORK_PATH')   OR DEFINE('FRAMEWORK_PATH',     __DIR__ . '/..');

/**
 * PROJECT_NAMESPACE should contains your project namespace, at least
 * the base namespace of your views and controllers.
 * 
 * This is used to automatically match your components
 * (views, controllers, ...) with an HTTP request without the need to prefix
 * all your requests with the namespace of your component's classes.
 * 
 * Example:
 * For the following routes, with PROJECT_NAMESPACE defined with '\Acme\Blog'
 * <ul>
 *   <li>/Home</li>
 *   <li>/Article/add</li>
 * </ul>
 * 
 * We will load the folowwing classes (located at):
 * <ul>
 *   <li>\Acme\Blog\Home (the-project/app/views/Home.php)</li>
 *   <li>\Acme\Blog\Article (the-project/app/controllers/Article.php)</li>
 * </ul>
 */
DEFINED('PROJECT_NAMESPACE') OR DEFINE('PROJECT_NAMESPACE', '\Knt\Framework\Sample');

/**
 * VIEWS_PATH defines where your views are located.
 * It is used with the AutomatedRouter feature of the framework.
 * 
 * Example:
 * For the following project directory structure, you could set
 * VIEWS_PATH to `the-project/app/views`.
 * <pre>
 * the-project
 *   vendor
 *     knt
 *       framework
 *     {...}
 *   app
 *     views
 *     controllers
 *     models
 * </pre>
 */
DEFINED('VIEWS_PATH')       OR DEFINE('VIEWS_PATH',         BASE_PATH . '/Sample');

/**
 * VIEWS_INDEX defines a default method called to render a view when no one
 * has been specified in the request.
 * 
 * Example:
 * For the following routes, if VIEWS_INDEX is defined with the value 'index':
 * <ul>
 *   <li>/Home</li>
 *   <li>/Article/list</li>
 * </ul>
 * 
 * We will render the following views using the method:
 * <ul>
 *   <li>\Acme\Blog\Home::index()</li>
 *   <li>\Acme\Blog\Article::list()</li>
 * </ul>
 * 
 * As we can see, no method has been specified for the view 'Home', so we
 * render the one called 'index' as defined by VIEWS_INDEX.
 */
DEFINED('VIEWS_INDEX')      OR DEFINE('VIEWS_INDEX',        'index');

/**
 * DEFAULT_VIEW defines a default view to render when no one
 * has been specified in the request.
 * 
 * Example:
 * For the following routes, if DEFAULT_VIEW is defined with the value 'Home':
 * <ul>
 *   <li>/</li>
 *   <li>/Article</li>
 * </ul>
 * 
 * We will render the following views using the method:
 * <ul>
 *   <li>\Acme\Blog\Home::index()</li>
 *   <li>\Acme\Blog\Article::index()</li>
 * </ul>
 * 
 * As we can see, no view has been specified for the root view '/', so we
 * render the one specified with DEFAULT_VIEW: 'Home', 
 * using the VIEWS_INDEX method.
 */
DEFINED('DEFAULT_VIEW')     OR DEFINE('DEFAULT_VIEW',       'Home');

/**
 * VIEWS_EXTENSION defines the extension of the files defining the view classes.
 * 
 * By default, the extension is '.php', but you may use something else
 * like '.inc.php', '.class.php', '.php5', or whatever you want.
 */
DEFINED('VIEWS_EXTENSION')  OR DEFINE('VIEWS_EXTENSION',    '.php');

/**
 * CONTROLLERS_PATH defines where your controllers are located.
 * It is used with the AutomatedRouter feature of the framework.
 * 
 * Example:
 * For the following project directory structure, you could set
 * CONTROLLERS_PATH to `the-project/app/controllers`.
 * <pre>
 * the-project
 *   vendor
 *     knt
 *       framework
 *     {...}
 *   app
 *     views
 *     controllers
 *     models
 * </pre>
 */
DEFINED('CONTROLLERS_PATH') OR DEFINE('CONTROLLERS_PATH',   BASE_PATH . '/Sample');

/**
 * CONTROLLERS_EXTENSION defines the extension of the files 
 * that defines your controllers class.
 * 
 * By default, the extension is '.php', but you may use something else
 * like '.inc.php', '.class.php', '.php5', or whatever you want.
 */
DEFINED('CONTROLLERS_EXTENSION') OR DEFINE('CONTROLLERS_EXTENSION', '.php');

/**
 * DEBUG_LEVEL is used to define the debug level of your application.
 * Actually, threre are 2 debug levels:
 * - 0: production mode: nothing specific is done to help debugging
 * - 1: debug mode: the time taken to render the view is added to the response.
 */
DEFINED('DEBUG_LEVEL')      OR DEFINE('DEBUG_LEVEL',        1);