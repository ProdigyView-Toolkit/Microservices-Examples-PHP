<?php
include (dirname(__FILE__).'/../vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\network\Request;
use prodigyview\network\Response;
use prodigyview\system\Security;

//Create And Process The Current Request
$request = new Request();

//Get The Request Method(GET, POST, PUT, DELETE)
$method = strtolower($request->getRequestMethod());

//RETRIEVE Data From The Request
$data = $request->getRequestData('array');

//Create A Socket Connection
$socket = getSocket();

//Route The Methods
if ($method === 'post') {
	post($data, $socket);
} else if ($method === 'put') {
	parse_str($data,$data);
	put($data, $socket);
} else {
	sendResponse(json_encode(array('status' => 'No Service Found')));
}

/**
 * Process the post request for sending an email
 */
function post(array $data = array(), Socket $socket) {

	$response = array();

	if ($data) {
		//Add Token To Check
		$data['token'] = 'ABC123-NotRealToken';
		$data['type']='email';

		//JSON encode the message
		$message = json_encode($data);
		
		//Send The Message
		$result = sendMessage($message, $socket);

		//Create a response from the microservice
		$response = array('status' => $result);
	} else {
		$response = array('status' => 'Unable To Send Email');
	}
	
	//Send response to client who accessed the API
	sendResponse(json_encode($response));
};

/**
 * Process the put request for sending a push notification
 */
function put(array $data = array(), Socket $socket) {

	$response = array();

	if ($data) {
		//Add Token To Check
		$data['token'] = 'ABC123-NotRealToken';
		$data['type']='push_notification';

		//JSON encode the message
		$message = json_encode($data);
		
		//Send The Message
		$result = sendMessage($message, $socket);

		//Create a response from the microservice
		$response = array('status' => $result);
	} else {
		$response = array('status' => 'Unable To Send Email');
	}
	
	//Send response to client who accessed the API
	sendResponse(json_encode($response));
};

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
function sendMessage(string $message, Socket $socket) {
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
