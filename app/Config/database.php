<?php
class DATABASE_CONFIG {
	public $default = array(
	 "datasource" => "Database/Sqlserver",
	 "persistent" => false,
	 "host" => "WIN7PRO-PC\SQLSERVER2008",
	 "login" => "",
	 "password" => "",
	 "database" => "ECWP-eReleveData",
	 "prefix" => ""
	);
	
	public $ereleveArgos = array(
	 "datasource" => "Database/Sqlserver",
	 "persistent" => false,
	 "host" => "SERVEUR2008\SQLSERVER2008",
	 "login" => "eReleveApplication",
	 "password" => "123456",
	 "database" => "ECWP_eReleve_Argos",
	 "prefix" => ""
	);	
	
	public $ereleveSensor= array(
	 "datasource" => "Database/Sqlserver",
	 "persistent" => false,
	 "host" => "SERVEUR2008\SQLSERVER2008",
	 "login" => "eReleveApplication",
	 "password" => "123456",
	 "database" => "ECWP_eReleve_Sensor",
	 "prefix" => ""
	);	
	
	public $user = array(
	 "datasource" => "Database/Sqlserver",
	 "persistent" => false,
	 "host" => "WIN7PRO-PC\SQLSERVER2008",
	 "login" => "",
	 "password" => "",
	 "database" => "ECWP_TRACK_SECURITE",
	 "prefix" => "",
	 "encoding" => "",
	);

}
?>