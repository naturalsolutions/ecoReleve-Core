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
	Router::connect('/protocole/get/:id_proto',array('controller'=>'proto','action' => 'proto_get','id_proto'=>'[0-9]+'));  //get structure of protocole url
	Router::connect('/protocole/get',array('controller'=>'proto','action' => 'proto_get'));
	Router::connect('/protocole/taxon/list',array('controller'=>'proto','action' => 'proto_taxon_get'));  //get proto's taxons url
	
	Router::connect('/fieldactivity/list/autocomplete',array('controller'=>'NSML','action' => 'fa_list'));
	Router::connect('/region/list/autocomplete',array('controller'=>'NSML','action' => 'region_list'));  //get region list url
	Router::connect('/place/list/autocomplete',array('controller'=>'NSML','action' => 'place_list'));  //get place list url
	
	Router::connect('/nsml/get',array('controller'=>'NSML','action' => 'nsml_get'));  //get nsml from view url
	Router::connect('/nsml/get/count',array('controller'=>'NSML','action' => 'nsml_get','count' => 'yes'));  //get nsml from view url
	
	Router::connect('/station/list',array('controller'=>'station','action' => 'station_get'));  //get station url
	Router::connect('/station/list2',array('controller'=>'station','action' => 'station_get2'));  //get station url
	Router::connect('/station/carto',array('controller'=>'Carto','action' => 'station_get')); //get stations for openlayer url
	Router::connect('/station/carto2',array('controller'=>'station','action' => 'station_get2','format' => 'geojson'));  //get station url
	Router::connect('/station/import_csv',array('controller'=>'station','action' => 'import_csv'));  

	Router::connect('/view/list',array('controller'=>'views','action' => 'views_list'));
	Router::connect('/view/get/:table_name',array('controller'=>'views','action' => 'get_view'));
	Router::connect('/view/get/:table_name/count',array('controller'=>'views','action' => 'get_view','count' => 'yes'));
	Router::connect('/view/detail/:table_name',array('controller'=>'views','action' => 'detail_view'));
	
	Router::connect('/user/list',array('controller'=>'User','action' => 'listv'));  //get list of user
	Router::connect('/user',array('controller'=>'tusers','action' => 'index'));  
	Router::connect('/user/login/:login/:password',array('controller'=>'User','action' => 'login'));  //login action	
	
	
	Router::connect('/doc/list',array('controller'=>'Docs','action' => 'docs_list'));
	
	Router::connect('/taxon/get',array('controller'=>'taxon','action' => 'taxon_get'));  //get taxon url
	Router::connect('/taxon/get/:id_taxon',array('controller'=>'taxon','action' => 'taxon_get','id_taxon'=>'[0-9]+'));  //get taxon url with id
	Router::connect('/taxon/list/autocomplete',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa_Name','column_name' => 'NAME_WITHOUT_AUTHORITY','fields'=>'NAME_WITHOUT_AUTHORITY'));
	Router::connect('/taxon/list',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa_Name','column_name' => 'NAME_WITHOUT_AUTHORITY',
	'table_join'=>'TTaxa','fields'=>'ID_NAME,NAME_WITHOUT_AUTHORITY,AUTHORITY,FK_Taxon','join_column'=>'TTaxaJoin.NAME_VALID_WITH_AUTHORITY,TTaxaJoin.NAME_VERN_FR,TTaxaJoin.RANK',
	'fk'=>'FK_Taxon','pk'=>'TTaxaJoin.ID_TAXON','column_name2'=>'TTaxaJoin.NAME_VERN_FR'));
	Router::connect('/taxon/list/count',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa_Name','column_name' => 'NAME_WITHOUT_AUTHORITY','count'=>'yes'));

	Router::connect('/vernacular/list/autocomplete',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa','column_name' => 'NAME_VERN_FR','fields'=>'NAME_VERN_FR'));
	Router::connect('/vernacular/list',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa','column_name' => 'NAME_VERN_FR'
	,'fields'=>'ID_TAXON,NAME_VALID_WITHOUT_AUTHORITY,NAME_VALID_AUTHORITY,NAME_VALID_WITH_AUTHORITY,NAME_VERN_FR,RANK'));

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
