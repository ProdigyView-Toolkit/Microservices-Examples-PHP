<?php
include_once (dirname(__FILE__) . '/../vendor/autoload.php');

use prodigyview\system\Security;
use prodigyview\network\Socket;

//Mock logins for the system. In production, this would be a database
//Contains login, password, and the privileges that login has
$logins = array(
	'1'=> array('login' =>'user1', 'password'=>'abc123' , 'privileges' => array('*')),
	'2'=> array('login' =>'user2', 'password'=>'123456' , 'privileges' => array('send_notification', 'send_email')),
	'3'=> array('login' =>'user3', 'password'=>'qwerty', 'privileges' => array('purchase', 'refund')),
);

//Mock tokens for the system. Should also be stored in a database
$tokens = array();

include('functions.php');

//For the demo, we are going to store a mock token
storeToken('39e9289a5b8328ecc4286da11076748716c41ec', $tokens, strtotime('+1 minute'));


//Create The Server
$server = new Socket('localhost', 8600, array(
	'bind' => true,
	'listen' => true
));

//Start The Server
$server->startServer('', function($message) {

	echo "Processing...\n";

	//Decrypt our encrypted message
	Security::init();
	$message = Security::decrypt($message);

	//Turn the data into an array
	$data = json_decode($message, true);

	//Default response
	$response = array('status' => 'error', 'message' => 'Nothing found.');
	
	//Execute A Request If Exist
	if(isset($data['request'])) {
	
		//Request A Token
		if($data['request'] == 'authenticate') {
			global $logins;
			global $tokens;
			if($id = authenticate($data['login'], $data['password'], $logins )) {
				$token = createAccessToken($logins[$id], $tokens, strtotime('+1 minute'));
				$response = array('status' => 'success', 'token' => $token);
			} else {
				$response = array('status' => 'error', 'message' => 'Invalid Login');
			}
			
		} 
		//Authorize a token based action
		else if($data['request'] == 'authorize') {
			global $tokens;
			
			if(validateToken($data['token'], $data['action'], $tokens, time())) {
				consumeToken($data['token'], $tokens);
				$response = array('status' => 'success', 'message' => 'Access Granted');
			} else {
				$response = array('status' => 'error', 'message' => 'Invalid Token On Authorization');
			}
			
		}

	}

	//JSON encode the response
	$response =json_encode($response);
	
	//Return an encrypted message
	return Security::encrypt($response);

}, 'closure');



