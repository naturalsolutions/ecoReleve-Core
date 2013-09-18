<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
 
	//router config for the cake project
	Router::connect('/protocole/list',array('controller'=>'proto','action' => 'proto_list'));  //get list of protocole url
	Router::connect('/protocole/structure',array('controller'=>'proto','action' => 'proto_get'));  //get structure of protocole url
	Router::connect('/station/get',array('controller'=>'proto','action' => 'station_get'));  //get station url
	Router::connect('/protocole/taxon/list',array('controller'=>'proto','action' => 'station_get'));  //get station url
	Router::connect('/view/map_export',array('controller'=>'NSML','action' => 'map_views_list')); //get map export views
	Router::connect('/fa/list',array('controller'=>'NSML','action' => 'fa_list'));  //get field activity list url
	Router::connect('/region/list',array('controller'=>'NSML','action' => 'region_list'));  //get region list url
	Router::connect('/place/list',array('controller'=>'NSML','action' => 'place_list'));  //get place list url
	Router::connect('/nsml/get',array('controller'=>'NSML','action' => 'nsml_get'));  //get nsml from view url
	Router::connect('/user/get',array('controller'=>'User','action' => 'listv'));  //get nsml from view url
	Router::connect('/carto/station/get',array('controller'=>'Carto','action' => 'station_get')); //get stations for openlayer url
	
	
	
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();
	//Router::mapResources('proto');
	Router::parseExtensions();
	//Router::parseExtensions('xml');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
