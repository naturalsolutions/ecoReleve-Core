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
	Return the list of protocols
	
	• /protocole/get/:id_proto
	Return one protocole with id=id_proto
	
	• /protocole/get parameter(s) : proto_name
	Return one protocole with protocole name=proto_name
	
	• /protocole/taxon/list parameter(s) : id_proto
	Return  protocole's taxons from the protocole with id_proto=proto_name
-----------------
	• /fieldactivity/list/autocomplete
	List of field activity used
	
	• /region/list/autocomplete
	List of field activity used
	
	• /place/list/autocomplete
	List of field activity used

Twitter
------------
Please consider following the [@Nat_Solutions](https://twitter.com/Nat_Solutions) Twitter team for updates.

Commercial Support
------------

We have programs for companies that require additional level of assistance through training or commercial support, need special licensing or want additional levels of capabilities. Please visit the  [Natural Solutions](http://www.natural-solutions.eu/) Website for more information about ecoRelevé or email contact@natural-solutions.com.

Sponsor
------------

We are grateful to H.H. Sheikh Mohamed bin Zayed Al Nahyan, Crown Prince of Abu Dhabi and Chairman of the International Fund for Houbara Conservation (IFHC) and  H.E. Mohammed Al Bowardi Deputy Chairman of IFHC for their support
