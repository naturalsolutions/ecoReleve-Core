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
	
	Router::connect('/station/area',array('controller'=>'station','action' => 'station_get','areautocomplete' => 'yes'));
	Router::connect('/station/locality',array('controller'=>'station','action' => 'station_get','localityautocomplete'=>'yes'));
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
	Router::connect('/user/fieldworker',array('controller'=>'User','action' => 'fieldworkers')); 
	
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

	
	Router::connect('/TViewIndividual/list',array('controller'=>'TViewIndividual','action' => 'column_list','table_name' => 'TViewIndividual'
	,'column_name' => 'Individual_Obj_PK','fields'=>'Individual_Obj_PK as ID
	,id60@TCaracThes_Monitoring_Status_Precision as Monitoring_status,
	id61@TCaracThes_Survey_type_Precision as Survey_type
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
	Router::connect('/TViewIndividual/add',array('controller'=>'TViewIndividual','action' => 'add'));
	Router::connect('/TViewIndividual/:id/carac',array('controller'=>'TViewIndividual','action' => 'detail','carac'=>'yes'));
	Router::connect('/TViewIndividual/:id/protocole',array('controller'=>'TViewIndividual','action' => 'getproto'));
	Router::connect('/TViewIndividual/:id',array('controller'=>'TViewIndividual','action' => 'detail'));
		
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
	Router::connect('/TViewTrx_Radio/:id/carac',array('controller'=>'TViewTrx_Radio','action' => 'detail','carac'=>'yes'));
	Router::connect('/TViewTrx_Radio/:id',array('controller'=>'TViewTrx_Radio','action' => 'detail'));
	
	
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
	Router::connect('/TViewTrx_Sat/:id/carac',array('controller'=>'TViewTrx_Sat','action' => 'detail','carac'=>'yes'));
	Router::connect('/TViewTrx_Sat/:id',array('controller'=>'TViewTrx_Sat','action' => 'detail'));
	
	
	Router::connect('/argos/stat',array('controller'=>'Sensor','action' => 'argos_stat'));
	Router::connect('/sensor/stat',array('controller'=>'Sensor','action' => 'log_stat'));

	Router::connect('/list/autocomplete',array('controller'=>'app','action' => 'column_list'));
	
	Router::connect('/thesaurus/autocomplete/distanceFromObserver/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000003'));
	Router::connect('/thesaurus/autocomplete/distanceFromObserver/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000003','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/typeSiteMonitired/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18989'));
	Router::connect('/thesaurus/autocomplete/typeSiteMonitired/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18989','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/habitat/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'522045552'));
	Router::connect('/thesaurus/autocomplete/habitat/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'522045552','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/microHabitat/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'78959463'));
	Router::connect('/thesaurus/autocomplete/microHabitat/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'78959463','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/especePlant/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'65346788'));
	Router::connect('/thesaurus/autocomplete/especePlant/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'65346788','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/especeVertebre/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139238005'));
	Router::connect('/thesaurus/autocomplete/especeVertebre/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139238005','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/especeInvertebre/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'197630907'));
	Router::connect('/thesaurus/autocomplete/especeInvertebre/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'197630907','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/especeChiro/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139238005'));
	Router::connect('/thesaurus/autocomplete/especeChiro/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139238005','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/geomorphology/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'25644'));
	Router::connect('/thesaurus/autocomplete/geomorphology/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'25644','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/typeSignal/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1803866642'));
	Router::connect('/thesaurus/autocomplete/typeSignal/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1803866642','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/sex/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18872'));
	Router::connect('/thesaurus/autocomplete/sex/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18872','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/age/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18876'));
	Router::connect('/thesaurus/autocomplete/age/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18876','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/posture/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1870537855'));
	Router::connect('/thesaurus/autocomplete/posture/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1870537855','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/behaviour/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1032620'));
	Router::connect('/thesaurus/autocomplete/behaviour/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1032620','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/maleReproductionState/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18845'));
	Router::connect('/thesaurus/autocomplete/maleReproductionState/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18845','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/femaleReproductionState/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18847'));
	Router::connect('/thesaurus/autocomplete/femaleReproductionState/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18847','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/femaleMaturityState/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18855'));
	Router::connect('/thesaurus/autocomplete/femaleMaturityState/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18855','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/observationTool/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105657'));
	Router::connect('/thesaurus/autocomplete/observationTool/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105657','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/weather/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'986361943'));
	Router::connect('/thesaurus/autocomplete/weather/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'986361943','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/windForce/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105648'));
	Router::connect('/thesaurus/autocomplete/windForce/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105648','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/topographie/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105652'));
	Router::connect('/thesaurus/autocomplete/topographie/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105652','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/substrat/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105653'));
	Router::connect('/thesaurus/autocomplete/substrat/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105653','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/exposure/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'676432358'));
	Router::connect('/thesaurus/autocomplete/exposure/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'676432358','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/slope/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'631260503'));
	Router::connect('/thesaurus/autocomplete/slope/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'631260503','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/edaphicHygrotrophy/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18840'));
	Router::connect('/thesaurus/autocomplete/edaphicHygrotrophy/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18840','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/pHCategories/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105649'));
	Router::connect('/thesaurus/autocomplete/pHCategories/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105649','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/soilTexture/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105650'));
	Router::connect('/thesaurus/autocomplete/soilTexture/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105650','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/vegetationSeries/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105651'));
	Router::connect('/thesaurus/autocomplete/vegetationSeries/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105651','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/entomologicalAbundance/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105654'));
	Router::connect('/thesaurus/autocomplete/entomologicalAbundance/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105654','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/humanImpacts/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'884219051'));
	Router::connect('/thesaurus/autocomplete/humanImpacts/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'884219051','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/captureMethode/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19001'));
	Router::connect('/thesaurus/autocomplete/captureMethode/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19001','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/captureMethodeEntomo/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18810'));
	Router::connect('/thesaurus/autocomplete/captureMethodeEntomo/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18810','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/houbaraRemains/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19033'));
	Router::connect('/thesaurus/autocomplete/houbaraRemains/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19033','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/deathTime/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19036'));
	Router::connect('/thesaurus/autocomplete/deathTime/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19036','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/reasonOfDeath/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19018'));
	Router::connect('/thesaurus/autocomplete/reasonOfDeath/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19018','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/typesOfTracks/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139846854'));
	Router::connect('/thesaurus/autocomplete/typesOfTracks/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1139846854','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/clutchDescription/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'578416852'));
	Router::connect('/thesaurus/autocomplete/clutchDescription/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'578416852','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/eggStatus/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'578416851'));
	Router::connect('/thesaurus/autocomplete/eggStatus/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'578416851','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/fieldMethodsOrnithology/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19001'));
	Router::connect('/thesaurus/autocomplete/fieldMethodsOrnithology/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'19001','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/abundanceDominance/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'45007632'));
	Router::connect('/thesaurus/autocomplete/abundanceDominance/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'45007632','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/sociability/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'964734638'));
	Router::connect('/thesaurus/autocomplete/sociability/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'964734638','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/growthStages/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2046544492'));
	Router::connect('/thesaurus/autocomplete/growthStages/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2046544492','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/countingClasses/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'412701554'));
	Router::connect('/thesaurus/autocomplete/countingClasses/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'412701554','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/emettorShapes/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1184603295'));
	Router::connect('/thesaurus/autocomplete/emettorShapes/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1184603295','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/transmittorModel/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'125179343','hierarchy'=>'001.002.035.001.%'));
	Router::connect('/thesaurus/autocomplete/transmittorModel/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'125179343','hierarchy'=>'001.002.035.001.%','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/argosModel/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'125179343','hierarchy'=>'001.002.035.002.%'));
	Router::connect('/thesaurus/autocomplete/argosModel/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'125179343','hierarchy'=>'001.002.035.002.%','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/ringPosition/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1384143493'));
	Router::connect('/thesaurus/autocomplete/ringPosition/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1384143493','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/color/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1995579426'));
	Router::connect('/thesaurus/autocomplete/color/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1995579426','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/manufacturers/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000051','hierarchy'=>'001.002.077.002.%'));
	Router::connect('/thesaurus/autocomplete/manufacturers/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000051','hierarchy'=>'001.002.077.002.%','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/manufacturersArgos/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000051','hierarchy'=>'001.002.077.001.%'));
	Router::connect('/thesaurus/autocomplete/manufacturersArgos/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000051','hierarchy'=>'001.002.077.001.%','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/origine/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18902'));
	Router::connect('/thesaurus/autocomplete/origine/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'18902','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/monitoringStatus/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105659'));
	Router::connect('/thesaurus/autocomplete/monitoringStatus/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'2097105659','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/typesOfStockEvents/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1268451131'));
	Router::connect('/thesaurus/autocomplete/typesOfStockEvents/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1268451131','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/implementationSystem/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000157'));
	Router::connect('/thesaurus/autocomplete/implementationSystem/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000157','count'=>'yes'));
	Router::connect('/thesaurus/autocomplete/batteryType/list',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000244'));
	Router::connect('/thesaurus/autocomplete/batteryType/count',array('controller'=>'Thesaurus','action' => 'getthesaurus','id_type'=>'1000244','count'=>'yes'));
	
	
	
	
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
