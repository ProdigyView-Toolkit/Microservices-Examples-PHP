<?php
/**
 * In this file, we are setting up the system by specifying options and how they will be set depending on the environment.
 * In this example, there are two environments, production and development. You have the ability to create as many
 * as you want.
 *
 * The environment variables are only set here, they are called and implemented in other parts of the bootstrap
 * and in the application itself.
 */
date_default_timezone_set('America/New_York');

ini_set('display_errors', 'On');

$_SERVER['HTTPS'] = 'off';

/***************************************
 * Databases
 ***************************************/

//Set the main postgresql database
Configuration::addConfiguration('postgres', array(
    'dbprefix' => '',
    'dbhost' => 'postgres',    //host
    'dbname' => 'helium',                                                              //database name
    'dbuser' => 'helium',
    'dbpass' => 'helium',                                                                   //user's password
    'dbtype' => 'postgresql',                                                                       //database type
    'dbschema' => 'public',                                                                            //schema(optional)
    'dbport' => '5432',                                                                               //table prefix(optional)
));

//Set the database for articles
Configuration::addConfiguration('mysql', array(
    'dbhost' => 'mysql',     //host
    'dbname' => 'helium',                                                              //database name
    'dbuser' => 'root',
    'dbpass' => 'helium',                                                                     //user's password
    'dbtype' => 'mysql',                                                                       //database type
    'dbschema' => '',                                                                           //schema(optional)
    'dbport' => '3306',                                                                             //port(optional)
    'dbprefix' => ''                                                                                //table prefix(optional)
));

//Mongo Connection
Configuration::addConfiguration('mongo', array(
        'dbhost' => 'mongodb',
        'dbname' => 'helium',
        'dbuser' => 'helium',                                                                        
        'dbpass' => 'helium',
        'dbtype' => 'mongo',
        'dbschema' => '', 
        'dbport' => 27017,
        'dbprefix' => '',
));

//Caching DB
Configuration::addConfiguration('redis', array(
    'host' => 'redis',
    'port' => 6379
));

//Set the s3 parameters
Configuration::addConfiguration('s3', array(
    'secret' => '',
    'key' => '',
    'bucket' => '',
    'acl' => ''
));

//Set the session arguments for the development environment
Configuration::addConfiguration('session', array(
    'cookie_lifetime' => 1 * 365 * 24 * 60 * 60,                            //Set the lifetime of the cookie
    'sesssion_lifetime' => 1 * 365 * 24 * 60 * 60,                          //Set the lifetime of the session
    'session_name' => 'he2mvc_dev',     //Set the name of the session
    'hash_cookie' => false,                                         //Do not hash cookies,
    'session_domain' => '.he2examples.local',
    'cookie_domain' => '.he2examples.local',
));

//Website Urls
Configuration::addConfiguration('sites', array(
    'main' => 'http://www.he2examples.local/',
    'site1' => 'http://site1.he2examples.local/',
    'site2' => 'http://site2.he2examples.local/',
    'site3' => 'http://site3.he2examples.local/',
    'api' => 'http://api.he2examples.local/',
));


//Set the mail arguments for the development site
Configuration::addConfiguration('mail', array(
	'mailer' => 'php', 
	'login' => '', 
	'password' => '', 
	'port' => 587, 
	'host' => 'smtp.mailgun.org', 
	'from_address' => '',
	'from_name' => '',
));

//Set the mail arguments for the development site
Configuration::addConfiguration('firebase', array(
	'jsonFile' => PV_ROOT.DS.'app/config/google-service-account.json', 
));
