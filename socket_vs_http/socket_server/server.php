<?php
include_once (dirname(__FILE__) . '/../vendor/autoload.php');

use prodigyview\system\Security;
use prodigyview\network\Socket;

//Create The Server
$server = new Socket('localhost', 8650, array(
	'bind' => true,
	'listen' => true
));

//Start The Server
$server->startServer('', function($message) {

	//Decrypt our encrypted message
	Security::init();
	$message = Security::decrypt($message);

	//Turn the data into an array
	$data = json_decode($message, true);

	//Default response
	$response = array('status' => 'success', 'message' => 'Responding');

	//JSON encode the response
	$response =json_encode($response);
	
	//Return an encrypted message
	return Security::encrypt($response);

}, 'closure');



