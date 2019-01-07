<?php
include ('vendor/autoload.php');

use prodigyview\network\Router;
use prodigyview\network\Request;
use prodigyview\network\Response;
use prodigyview\network\Socket;
use prodigyview\system\Security;

include('authbearer/AuthBearer.php');

Router::init();
Security::init();

Router::post('/products/purchase', array('callback'=>function(Request $request){
	
	$response = array();
	
	//RETRIEVE Data From The Request
	$data = $request->getRequestData('array');
	

	if ($data) {
		$data['type']='charge';
		
		//Send The Message
		$result = sendToPurchaseService($data);

		//Create a response from the microservice
		$response = array('status' => $result);
	} else {
		$response = array('status' => 'Unable To Send Email');
	}
	
	//Send response to client who accessed the API
	sendResponse(json_encode($response));
}));

Router::post('/products/refund', array('callback'=>function(Request $request){
	//RETRIEVE Data From The Request
	$data = $request->getRequestData('array');

	$response = array();

	if ($data) {
		
		$data['type']='refund';
		
		//Send The Message
		$result = sendToPurchaseService($data);

		//Create a response from the microservice
		$response = array('status' => $result);
	} else {
		$response = array('status' => 'Unable To Perform Refund');
	}
	
	//Send response to client who accessed the API
	sendResponse(json_encode($response));
}));

Router::setRoute();

/**
 * Open a socket to the microservice
 */
function getSocket() {
	$host = '127.0.0.1';
	$port = 8502;
	$socket = new Socket($host, $port, array('connect' => true));

	return $socket;
}

/**
 * Send the message to microservice
 */
function sendToPurchaseService(array $message) {
	
	//Get the token and attached to message
	$token = AuthBearer::getToken('user1', 'abc123');
	$message['token']=$token;
	
	$socket = new Socket('127.0.0.1', 8601, array('connect' => true));
	
	$message = json_encode($message);
	//Encrypt The Message
	Security::init();
	$message = Security::encrypt($message);

	//Send Data To Email Processing
	$result = $socket->send($message);

	//Decrypt the Encrypted message
	$result = Security::decrypt($result);
	
	$socket->close();

	return $result;
}

/**
 * Send a response to the api client
 */
function sendResponse(string $message, int $status = 200) {
	echo Response::createResponse(200, $message);
}


