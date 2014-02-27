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
 
 
	/*_____________to delete old route_________________________*/
	Router::connect('/protocole/list',array('controller'=>'proto','action' => 'proto_list'));  //get list of protocole url
	Router::connect('/protocole/get/:id_proto',array('controller'=>'proto','action' => 'proto_get','id_proto'=>'[0-9]+'));  //get structure of protocole url
	Router::connect('/station/get',array('controller'=>'station','action' => 'station_get'));  //get station url
	Router::connect('/protocole/taxon/list',array('controller'=>'proto','action' => 'proto_taxon_get'));  //get proto's taxons url
	Router::connect('/view/map_export/list',array('controller'=>'NSML','action' => 'map_views_list')); //get map export views list
	Router::connect('/fa/list',array('controller'=>'NSML','action' => 'fa_list'));  //get field activity list url
	Router::connect('/region/list',array('controller'=>'NSML','action' => 'region_list'));  //get region list url
	Router::connect('/place/list',array('controller'=>'NSML','action' => 'place_list'));  //get place list url
	Router::connect('/nsml/get',array('controller'=>'NSML','action' => 'nsml_get'));  //get nsml from view url
	Router::connect('/taxon/get',array('controller'=>'proto','action' => 'taxon_get','id_taxon'=>'[0-9]+'));  //get taxon url
	Router::connect('/taxon/get/:id_taxon',array('controller'=>'proto','action' => 'taxon_get','id_taxon'=>'[0-9]+'));  //get taxon url with id
	Router::connect('/COUNT/view/map_export/get',array('controller'=>'NSML','action' => 'nsml_get','count' => 'yes'));
	Router::connect('/taxon/list',array('controller'=>'proto','action' => 'column_list','table_name' => 'TTaxa_name','column_name' => 'NAME_WITHOUT_AUTHORITY'));
	Router::connect('/taxon/list/table',array('controller'=>'taxon','action' => 'column_list','table_name' => 'TTaxa_Name','column_name' => 'NAME_WITHOUT_AUTHORITY',
	'table_join'=>'TTaxa','fields'=>'ID_NAME,NAME_WITHOUT_AUTHORITY,AUTHORITY,FK_Taxon','join_column'=>'TTaxaJoin.NAME_VALID_WITH_AUTHORITY,TTaxaJoin.NAME_VERN_FR,TTaxaJoin.RANK',
	'fk'=>'FK_Taxon','pk'=>'TTaxaJoin.ID_TAXON','column_name2'=>'TTaxaJoin.NAME_VERN_FR'));	
	Router::connect('/user/list',array('controller'=>'User','action' => 'listv'));  //get nsml from view url
	Router::connect('/carto/station/get',array('controller'=>'Carto','action' => 'station_get')); //get stations for openlayer url
	Router::connect('/views/get/:table_name',array('controller'=>'views','action' => 'get_view'));
	Router::connect('/views/get/:table_name/count',array('controller'=>'views','action' => 'get_view','count' => 'yes'));
	Router::connect('/views/detail/:table_name',array('controller'=>'views','action' => 'detail_view'));	
	Router::connect('/views/get/:table_name/export',array('controller'=>'views','action' => 'get_view','export'=>'yes'));
	Router::connect('/docs/list',array('controller'=>'Docs','action' => 'docs_list'));
	/*______________________________*/
 
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
	Router::connect('/station/list/count',array('controller'=>'station','action' => 'station_get','count' => 'yes'));  //get station url
	Router::connect('/station/list2',array('controller'=>'station','action' => 'station_get2'));  //get station url
	Router::connect('/station/list2/count',array('controller'=>'station','action' => 'station_get2','count' => 'yes'));  //get station url
	Router::connect('/station/carto',array('controller'=>'Carto','action' => 'station_get')); //get stations for openlayer url
	Router::connect('/station/carto2',array('controller'=>'station','action' => 'station_get2','format' => 'geojson'));  //get station url
	Router::connect('/station/import_csv',array('controller'=>'station','action' => 'import_csv'));  
	Router::connect('/station/count/month',array('controller'=>'Station','action' => 'number_by_month'));
	
	Router::connect('/view/list',array('controller'=>'views','action' => 'views_list'));
	Router::connect('/view/theme/list',array('controller'=>'views','action' => 'themes_list'));
	Router::connect('/view/get/:table_name',array('controller'=>'views','action' => 'get_view'));
	Router::connect('/view/carto/:table_name',array('controller'=>'views','action' => 'get_view','format' => 'geojson'));
	Router::connect('/view/get/:table_name/count',array('controller'=>'views','action' => 'get_view','count' => 'yes'));
	Router::connect('/view/detail/:table_name',array('controller'=>'views','action' => 'detail_view'));
	Router::connect('/view/get/:table_name/export',array('controller'=>'views','action' => 'get_view','export'=>'yes'));
	
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

	
	Router::connect('/TViewIndividual/:id',array('controller'=>'TViewIndividual','action' => 'detail'));
	Router::connect('/TViewIndividual/list',array('controller'=>'TViewIndividual','action' => 'column_list','table_name' => 'TViewIndividual'
	,'column_name' => 'Individual_Obj_PK','fields'=>'Individual_Obj_PK as ID
	,id60@TCaracThes_Monitoring_Status_Precision as Monitoring_status,
	id61@TCaracThes_Survey_type as Survey_type
	,id5@TCarac_Transmitter_Frequency as VHF_frequency
	,id19@TCarac_PTT as PTT
	,id9@TCarac_Release_Ring_Code as Release_ring_code
	,id12@TCarac_Breeding_Ring_Code as Breeding_ring_code
	,id13@TCarac_Chip_Code as Chip_code
	,id55@TCarac_Mark_code_1 as Mark1_code
	,id56@TCarac_Mark_code_2 as Mark2_code,
	id30@TCaracThes_Sex_Precision as sex'
	,'count2' => 'yes','nogroup'=>'yes'));
	Router::connect('/TViewIndividual/list/count',array('controller'=>'TViewIndividual','action' => 'column_list','table_name' => 'TViewIndividual'
	,'column_name' => 'id2@Thes_Age','fields'=>'Individual_Obj_PK,id2@Thes_Age'
	,'count' => 'yes'));
	
	Router::connect('/TViewTrx_Radio/list',array('controller'=>'TViewTrx_Radio','action' => 'column_list','table_name' => 'TViewTrx_Radio'
	,'column_name' => 'id1@Thes_Status','fields'=>'Trx_Radio_Obj_PK as ID
	,id5@TCarac_Transmitter_Frequency as VHF_frequency
	,id6@TCarac_Transmitter_Serial_Number as Serial_number
	,id42@TCaracThes_Company_Precision as Manufacturer
	,id41@TCaracThes_Model_Precision as Model
	,id1@Thes_Status_Precision as Status'
	,'count2' => 'yes','nogroup'=>'yes'));
	Router::connect('/TViewTrx_Radio/list/count',array('controller'=>'TViewTrx_Radio','action' => 'column_list','table_name' => 'TViewTrx_Radio'
	,'column_name' => 'id1@Thes_Status','fields'=>'*','count' => 'yes'));
	
	Router::connect('/TViewTrx_Sat/list',array('controller'=>'TViewTrx_Sat','action' => 'column_list','table_name' => 'TViewTrx_Sat'
	,'column_name' => 'id1@Thes_Status','fields'=>'Trx_Sat_Obj_PK as ID
	,id19@TCarac_PTT as PTT
	,id49@TCarac_PTTAssignmentDate as PTT_date
	,id42@TCaracThes_Company_Precision as Manufacturer
	,id41@TCaracThes_Model_Precision as Model
	,id1@Thes_Status_Precision as Status'
	,'count2' => 'yes','nogroup'=>'yes'));
	Router::connect('/TViewTrx_Sat/list/count',array('controller'=>'TViewTrx_Sat','action' => 'column_list','table_name' => 'TViewTrx_Sat'
	,'column_name' => 'id1@Thes_Status','fields'=>'*','count' => 'yes'));
	
	Router::connect('/list/autocomplete',array('controller'=>'app','action' => 'column_list'));
	
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
