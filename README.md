ecoReleve-Core
==============

A free and open source application.

![ecoReleve](https://raw.github.com/NaturalSolutions/ecoReleve/master/Logos/logo-LABS_Core.jpg)

This Software allow access to a lot of ecoReleve's webservices.


Installation notes 
-----------------
 * Deploy on a apache or IIS server, with "sqlserver for php" plugin
 * Have sqlserver database with a eReleve base (Natural Solution's base)
 * Intall sqlserver native client 2012 

How to install [here] (https://github.com/NaturalSolutions/ecoReleve-Core/raw/master/Installe%20Cakephp%20sur%20IIS.pdf  "How to")


Contributing
------------

Want to contribute? Great!

EcoRelevé is an open source project. Please help us by contributing to documentation, reporting bugs, forking the code to add features or make bug fixes or promoting us on twitter, etc.

Technical details 
-----------------

• CakePHP Framework

Application details
-----------------
List of ecoReleve-core webservices routes ( many of them get a limit and offset(or skip) parameter):

	• /protocole/list parameter(s) : motcle
	Return the list of protocols. Can be filtered by 'motcle'
	
	• /protocole/get/:id_proto
	Return one protocole with id='id_proto'
	
	• /protocole/get parameter(s) : proto_name
	Return one protocole with protocole name='proto_name'
	
	• /protocole/taxon/list parameter(s) : id_proto
	Return  protocole's taxons from the protocole with id='id_proto'
-----------------
	• /fieldactivity/list/autocomplete
	List of field activity used
	
	• /region/list/autocomplete
	List of field activity used
	
	• /place/list/autocomplete
	List of field activity used
-----------------	
	• /nsml/get parameter(s) : table, place, region, fieldactivity, min-date, max-date
	Return a NSML from 'table'. It's a list of stations in a xml format from Natural Solution
	
	• /nsml/get/count parameter(s) : table
	Return the number of station concern by the request.
-----------------		
	• /station/list parameter(s) : id_proto, bbox, id_stations, filters[], idate, place, region, format=geojson
	List of station for a datatable js. Based in the old version of eReleve's station on database
		• 'id_proto' allow to show only the stations of that protocole
		• 'bbox' open layer bbox
		• 'id_stations' a list of station's id. The stations with this ids will be shown
		• 'filters[]' NS grid filter parameter
		• 'format=geojson' geojson return parameter
		• 'idate' date filter parameter. idate values : 'idate=week' this week, 'idate=month' this month, 'idate=year' this year, 'idate=begindate;enddate' date format=YYYY-MM-DD
		• 'place' parameter for filter the locality
		• 'region' parameter.
	
	• /station/carto parameter(s) : bbox, zoom, cluster, filters[]
	Return stations in a geojson
	Based in the old version of eReleve's station on database
		• 'zoom' open layer zoom value
		• 'cluster' = yes if we want clustered data
		• 'filters[]' NS grid filter parameter
	
	• /station/list2 parameter(s) : bbox, id_taxon, id_stations, format
	List of station for a table (with 'format'=datatablejs will return data for a datatablejs)
	Based in the new version of eReleve's station on database
		• 'id_taxon' allow to show only stations of that taxon
	
	• /station/carto2 parameter(s) : bbox, zoom, id_taxon, id_stations, cluster
	Return stations in a geojson. Based in the new version of eReleve's station on database
	
	• /station/count/month
	Return the number of station by month since the last 12 month
	
	• /station/area parameter(s) : all '/station/list' ws parameter
	List of area from station. Can be filtered
	
	• /station/locality parameter(s) : all '/station/list' ws parameter
	List of locality from station. Can be filtered
	
	• /station/import_csv parameter(s) : file
	Import of data (Stations and protocoles) from a csv
		• 'file' is the file to import (with form file)
-----------------	
	• /view/theme/list
	List of topic's view
	This is sql views of stations
	
	• /view/list parameter(s) : id_theme
	List of sql views from eReleve sortable by topic with 'id_theme'
		
	• /view/get/:table_name parameter(s) : filters[]
	List of stations for a table from the view 'table_name' filtered or not 
		• 'filters' contains columns value to filter result. Parameter use for NS grid
		
	• /view/carto/:table_name parameter(s) : filters[]
	Return stations in a geojson from the view 'table_name' filtered or not 
	
	• /view/get/:table_name/count parameter(s) : filters[] 
	Return the number stations from the view 'table_name' filtered or not 
	
	• /view/get/:table_name/export parameter(s) : filters[] 
	Create pdf,gpx,csv export files based on the filters 
	
	• /view/detail/:table_name
	Return the columns and their types of the view 'table_name'
-----------------
	• /user/list
	Return the list of users
	
	• /user/login parameter(s) : login, password
	Login webservice with 'login' and 'password' parameter
	
	• /user/fieldworker
	List of fieldworker (same as user list)
	
	• /user
	CRUD user
-----------------
	• /doc
	CRUD doc
	
	• /doc/list
	Return the list of documents
-----------------
	• /taxon
	CRUD taxon
	
	• /taxon/get/:id_taxon
	Return data of the taxon with id='id_taxon'
	
	• /taxon/list/autocomplete parameter(s) : filter
	List of taxon that begin with 'filter' for autocomplete
	
	• /taxon/list parameter(s) : filter
	List of taxon that begin with 'filter' for a table
	
	• /taxon/list/count parameter(s) : filter
	Count the number of taxon that begin with 'filter'
	
	• /vernacular/list/autocomplete parameter(s) : filter
	List of taxon with vernacular name that begin with 'filter' for autocomplete
	
	• /vernacular/list parameter(s) : filter
	List of taxon with vernacular name that begin with 'filter' for a table
	
	• /taxon/import/taxref parameter(s) : limit, offset, condition, taxrefversion, deletecond
	Import of taxon from a taxref table fieltred by 'condition'. You can use deletecond for
	avoid duplicated row.

	• /taxon/import/taxref/count parameter(s) : condition, taxrefversion
	Number of taxon with that 'condition'
	
	• /taxon//taxref/version/list
	List of taxref version in database
	
	• /taxon/taxref/list/autocomplete/:field parameter(s) : condition
	List autocomplete from taxref 'field'. used for taxonomy rang (kingdom, phylum, ...)
	
-----------------
	• /TViewTrx_Radio/:id 
	Return detail of a radio object 'id'
	
	• /TViewTrx_Radio/:id/carac 
	List of characteristic of each fields of a radio object since now and before
	
	• /TViewTrx_Radio/list parameter(s) : filters[]
	
	List of radio object. The parameters 'filters' use for NS grid
	• /TViewTrx_Radio/list/count :filters[]
	Number of radio. The 'filters' parameter can be used too
-----------------
	• /TViewTrx_Sat/:id 
	Return detail of a sat object 'id'
	
	• /TViewTrx_Sat/:id/carac 
	List of characteristic of each fields of a sat object since now and before
	
	• /TViewTrx_Sat/list parameter(s) : filters[]
	List of sat object. The parameters 'filters' use for NS grid
	
	• /TViewTrx_Sat/list/count : filters[]
	Number of sat. The 'filters' parameter can be used too
-----------------
	• /TViewIndividual/:id parameter(s) : id_protocole,date_depart, date_fin, format=geojson
	Return detail of an Individu 'id'. Can be filtred by date and 'id_protocole'. Use 'format=geojson' parameter for get a geojson 
	
	• /TViewIndividual/:id/carac 
	List of characteristic of each fields of an Individu since now and before
	
	• /TViewIndividual/list parameter(s) : filters[]
	List of Individu. The parameters 'filters' use for NS grid
	
	• /TViewIndividual/list/count : filters[]
	Number of Individu. The 'filters' parameter can be used too
	
	• /TViewIndividual/:id/protocole : date_depart, date_fin
	List of protocole from an Individu 'id'. Return also the number of individu by protocole and can be filtred by date
	Date format : YYYY-MM-DD
-----------------
	• /TViewRFID/:id 
	Return detail of a rfid object 'id'
	
	• /TViewRFID/:id/carac 
	List of characteristic of each fields of a rfid object since now and before
	
	• /TViewRFID/list parameter(s) : filters[]
	List of rfid object. The parameters 'filters' use for NS grid
	
	• /TViewRFID/list/count : filters[]
	Number of rfid. The 'filters' parameter can be used too
-----------------
	• /TViewCameraTrap/:id 
	Return detail of a camera trap object 'id'
	
	• /TViewCameraTrap/:id/carac 
	List of characteristic of each fields of a camera trap object since now and before
	
	• /TViewCameraTrap/list parameter(s) : filters[]
	List of camera trap object. The parameters 'filters' use for NS grid
	
	• /TViewCameraTrap/list/count : filters[]
	Number of camera trap. The 'filters' parameter can be used too
-----------------
	• /characteristic/edit parameter(s) POST : object_type object_id value carac_type id_carac begin_date end_date comments
	Edit an object. Create a new characteristic.
	
	• /object/add 
	Create a new object and return the id.
	
	• /object/delete/:id_object
	Delete object 'id_object'
-----------------
	• /argos/stat 
	Argos stat since the last 7 days based on a Argos table
	
	• /sensor/stat
	Sensor stat since the last 7 days based on a sensor table
-----------------
	• /list/autocomplete parameter(s) : table_name, column_name, filter
	Dynamic autocomplete. Return all value from table 'table_name' of the column 'column_name'. Can be filtered by 'filter'
-----------------
	Thesaurus web services 
	
	format : /thesaurus/autocomplete/'type'/list for a listing 
	or /thesaurus/autocomplete/'type'/count for a count
	
	parameter : 'searcheng' for english search, 'searchfr' for french search
	
	• /thesaurus/autocomplete/distanceFromObserver/list
	
	• /thesaurus/autocomplete/typeSiteMonitired/list
	
	• /thesaurus/autocomplete/habitat/list
	
	• /thesaurus/autocomplete/microHabitat/list
	
	• /thesaurus/autocomplete/especePlant/list
	
	• /thesaurus/autocomplete/especeVertebre/list
	
	• /thesaurus/autocomplete/especeInvertebre/list
	
	• /thesaurus/autocomplete/especeChiro/list
	
	• /thesaurus/autocomplete/geomorphology/list

	• /thesaurus/autocomplete/typeSignal/list
	
	• /thesaurus/autocomplete/sex/list
	
	• /thesaurus/autocomplete/age/list
	
	• /thesaurus/autocomplete/posture/list
	
	• /thesaurus/autocomplete/maleReproductionState/list
	
	• /thesaurus/autocomplete/femaleReproductionState/list
	
	• /thesaurus/autocomplete/femaleMaturityState/list
	
	• /thesaurus/autocomplete/observationTool/list
	
	• /thesaurus/autocomplete/weather/list
	
	• /thesaurus/autocomplete/windForce/list

	• /thesaurus/autocomplete/topographie/list

	• /thesaurus/autocomplete/substrat/list
	
	• /thesaurus/autocomplete/exposure/list

	• /thesaurus/autocomplete/slope/list
	
	• /thesaurus/autocomplete/edaphicHygrotrophy/list
	
	• /thesaurus/autocomplete/pHCategories/list
	
	• /thesaurus/autocomplete/soilTexture/list
	
	• /thesaurus/autocomplete/vegetationSeries/list
	
	• /thesaurus/autocomplete/entomologicalAbundance/list
	
	• /thesaurus/autocomplete/captureMethode/list
	
	• /thesaurus/autocomplete/captureMethodeEntomo/list
	
	• /thesaurus/autocomplete/houbaraRemains/list
	
	• /thesaurus/autocomplete/deathTime/list
	
	• /thesaurus/autocomplete/reasonOfDeath/list
	
	• /thesaurus/autocomplete/typesOfTracks/list
	
	• /thesaurus/autocomplete/clutchDescription/list
	
	• /thesaurus/autocomplete/eggStatus/list
	
	• /thesaurus/autocomplete/fieldMethodsOrnithology/list
	
	• /thesaurus/autocomplete/abundanceDominance/list
	
	• /thesaurus/autocomplete/sociability/list
	
	• /thesaurus/autocomplete/growthStages/list
	
	• /thesaurus/autocomplete/countingClasses/list
	
	• /thesaurus/autocomplete/emettorShapes/list
	
	• /thesaurus/autocomplete/transmittorModel/list
	
	• /thesaurus/autocomplete/argosModel/list
	
	• /thesaurus/autocomplete/ringPosition/list
	
	• /thesaurus/autocomplete/color/list
	
	• /thesaurus/autocomplete/manufacturers/list
	
	• /thesaurus/autocomplete/origine/list
	
	• /thesaurus/autocomplete/monitoringStatus/list
	
	• /thesaurus/autocomplete/typesOfStockEvents/list
	
	• /thesaurus/autocomplete/implementationSystem/list
	
	• /thesaurus/autocomplete/batteryType/list
	
	

Twitter
------------
Please consider following the [@Nat_Solutions](https://twitter.com/Nat_Solutions) Twitter team for updates.

Commercial Support
------------

We have programs for companies that require additional level of assistance through training or commercial support, need special licensing or want additional levels of capabilities. Please visit the  [Natural Solutions](http://www.natural-solutions.eu/) Website for more information about ecoRelevé or email contact@natural-solutions.com.

Sponsor
------------

We are grateful to H.H. Sheikh Mohamed bin Zayed Al Nahyan, Crown Prince of Abu Dhabi and Chairman of the International Fund for Houbara Conservation (IFHC) and  H.E. Mohammed Al Bowardi Deputy Chairman of IFHC for their support
