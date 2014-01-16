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


Contributing
------------

Want to contribute? Great!

EcoRelevé is an open source project. Please help us by contributing to documentation, reporting bugs, forking the code to add features or make bug fixes or promoting us on twitter, etc.

Technical details 
-----------------

• CakePHP Framework

Application details
-----------------
List of ecoReleve-core webservices routes :

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
	• /station/list parameter(s) : id_proto, bbox, id_stations
	List of station for a datatable js. Based in the old version of eReleve's station on database
		• 'id_proto' allow to show only the stations of that protocole
		• 'bbox' open layer bbox
		• 'id_stations' a list of station's id. The stations with this ids will be shown
	
	• /station/carto parameter(s) : bbox, zoom, cluster
	Return stations in a geojson
	Based in the old version of eReleve's station on database
		• 'zoom' open layer zoom value
		• 'cluster' = yes if we want clustered data
	
	• /station/list2 parameter(s) : bbox, id_taxon, id_stations, format
	List of station for a table (with 'format'=datatablejs will return data for a datatablejs)
	Based in the new version of eReleve's station on database
		• 'id_taxon' allow to show only stations of that taxon
	
	• /station/carto2 parameter(s) : bbox, zoom, id_taxon, id_stations, cluster
	Return stations in a geojson. Based in the new version of eReleve's station on database
		
	• /station/import_csv parameter(s) : file
	Import of data (Stations and protocoles) from a csv
		• 'file' is the file to import (with form file)
-----------------	
	• /view/theme/list
	List of topic's view
	This is sql views of stations
	
	• /view/list parameter(s) : id_theme
	List of sql views from eReleve sortable by topic with 'id_theme'
		
	• /view/get/:table_name parameter(s) : filters 
	List of stations for a table from the view 'table_name' filtered or not 
		• 'filters' contains columns value to filter result
		
	• /view/carto/:table_name parameter(s) : filters 
	Return stations in a geojson from the view 'table_name' filtered or not 
	
	• /view/get/:table_name/count parameter(s) : filters 
	Return the number stations from the view 'table_name' filtered or not 
	
	• /view/detail/:table_name
	Return the columns and their types of the view 'table_name'
-----------------
	• /user/list
	Return the list of users
	
	• /user/login parameter(s) : login, password
	Login webservice with 'login' and 'password' parameter
	
	• /user
	CRUD user
-----------------
	• /doc/list
	Return the list of documents
-----------------
	• /taxon/get/:id_taxon
	Return data of the taxon with id='id_taxon'
	
	• /taxon/list/autocomplete parameter(s) : filter
	List of taxon that begin with 'filter' for autocomplete
	
	• /taxon/list parameter(s) : filter
	List of taxon that begin with 'filter' for a table
	
	• /taxon/list/count parameter(s) : filter
	Count the number of taxon that begin with 'filter'
	
	• /vernacular/list/autocomplete : filter
	List of taxon with vernacular name that begin with 'filter' for autocomplete
	
	• /vernacular/list parameter(s) : filter
	List of taxon with vernacular name that begin with 'filter' for a table

Twitter
------------
Please consider following the [@Nat_Solutions](https://twitter.com/Nat_Solutions) Twitter team for updates.

Commercial Support
------------

We have programs for companies that require additional level of assistance through training or commercial support, need special licensing or want additional levels of capabilities. Please visit the  [Natural Solutions](http://www.natural-solutions.eu/) Website for more information about ecoRelevé or email contact@natural-solutions.com.

Sponsor
------------

We are grateful to H.H. Sheikh Mohamed bin Zayed Al Nahyan, Crown Prince of Abu Dhabi and Chairman of the International Fund for Houbara Conservation (IFHC) and  H.E. Mohammed Al Bowardi Deputy Chairman of IFHC for their support
