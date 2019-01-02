<?php
//Turn on error reporting
if(isset($_SERVER['ENV']) && $_SERVER['ENV'] == 'production'){
	ini_set('display_errors','Off');
} else {
	ini_set('display_errors','On');
}

error_reporting(E_ALL); 

$_SERVER['HTTP_HOST'] = null;

//Define Directory Seperator
define('DS', DIRECTORY_SEPARATOR);
//Define Prodigy View ROot
define('PV_ROOT', dirname(__DIR__) );
//Define heliums root
define('HELIUM', PV_ROOT.DS.'vendor'.DS.'prodigyview'.DS.'helium'.DS );
//Set to site path
define ('SITE_PATH', dirname ( __FILE__ ).DS);
//Set the location of the public folder
define('PUBLIC_HTML', SITE_PATH.DS.'public_html'.DS);
//Set the location of  local libraries
define('PV_LIBRARIES', SITE_PATH.DS.'libraries'.DS);
//Define Template Directory
define('PV_TEMPLATES', SITE_PATH.DS.'templates'.DS);
//Set the temp directory
define('PV_TMP', PUBLIC_HTML.'tmp'.DS);

include(PV_ROOT.DS.'vendor'.DS. 'autoload.php');

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

prodigyview\helium\HeliumConsole::addObserver('prodigyview\helium\HeliumConsole::init', 'read_closure', function() {
  
  //Load the site boostrap
  include SITE_PATH.'config/bootstrap.php';
   
}, array('type' => 'closure'));

prodigyview\helium\HeliumConsole::init();

exit();
 