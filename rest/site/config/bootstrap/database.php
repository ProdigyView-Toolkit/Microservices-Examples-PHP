<?php
/**
 * The file should only contain the database configuration. Please not that you can
 * define multiple database connections each and they will be loaded automatically
 * at run time. Connections can also be added manually by using the Database::add()
 * function.
 *
 * dbhost - The host or ip the database is on
 * dbuser - The username to connected to the database
 * dbpass - The password the user uses to connect to the database
 * dbtype - The type of database. Options are mysql - postgresql - mssql- mongo
 * dbname - The name of the database on the host
 * dbport - Optional. The port that is used to connect to the database
 * dbschema - Optional. The schema the database is on (generally used in PostgreSQL)
 * dbprefix - Optional. A prefix that will be placed in front of every table.
 *
 * Sample
 *
 * $connections['connection_1']['dbhost']='xxx.xxxx.xxx';
 * $connections['connection_1']['dbuser']='auser';
 * $connections['connection_1']['dbpass']='apassword';
 * $connections['connection_1']['dbtype']='mysql';
 * $connections['connection_1']['dbname']='databasename';
 * $connections['connection_1']['dbport']='';
 * $connections['connection_1']['dbschema']='aschema';
 * $connections['connection_1']['dbprefix']='pv_';
 */
use prodigyview\system\Database;
use prodigyview\system\Configuration;

/**
 * The connect below is based upon the configuration in
 * the environments.php file
 */
$database = Configuration::getConfiguration('mysql');

//Add The Connection
Database::addConnection('sql', array(
	'dbhost' => $database->dbhost,
	'dbuser' => $database->dbuser,
	'dbpass' => $database->dbpass,
	'dbtype' => $database->dbtype,
	'dbname' => $database->dbname,
	'dbport' => $database->dbport,
	'dbschema' => $database->dbschema,
	'dbprefix' => $database->dbprefix
));

//Set the current connection
Database::setDatabase('sql');
