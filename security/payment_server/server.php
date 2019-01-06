<?php
include_once (dirname(__FILE__) . '/../vendor/autoload.php');

use prodigyview\system\Security;
use prodigyview\network\Socket;

//Mock logins for the system. In production, this would be a database
//Contains login, password, and the privileges that login has
$charges = array(
	'123456'=> array(
		'amount' => '10',
		'status' => 'charged',
		'meta' => array('product_id'=> 'x3c3', 'account_id'=>1)
	),
	'789012'=> array(
		'amount' => '20',
		'status' => 'refunded',
		'meta' => array('product_id'=> 'c8d0', 'account_id'=>2)
	),
);

$nounces = array(
	'1c46538c712e9b5bf0fe43d692',
	'004f617b494d004e29daaf'
);

//Mock tokens for the system. Should also be stored in a database
$tokens = array();

include('functions.php');
include_once (dirname(__FILE__) . '/../authbearer/AuthBearer.php');

//Create The Server
$server = new Socket('localhost', 8601, array(
	'bind' => true,
	'listen' => true
));

//Start The Server
$server->startServer('', function($message) {
	global $nounces;
	global $charges;
	
	echo "Processing...\n";

	//Decrypt our encrypted message
	Security::init();
	$message = Security::decrypt($message);

	//Turn the data into an array
	$data = json_decode($message, true);

	$response = array('status' => 'error', 'message' => 'Invalid Command');
	
	$type = (isset($data['type'])) ? $data['type'] : '';

	//Verify that the correct token is being used
	if (isset($data['token']) && AuthBearer::hasAccess($data['token'], $type)) {

		if($type == 'charge' && checkNounce($data['nounce'], $nounces)) {
			$id = charge($data['amount'], $data['nounce'], array('product' => 'Shoes'), $charges);
			$response = array('status' => 'success', 'message' => $id);
		}else if($type == 'charge') {
			$response = array('status' => 'error', 'message' => 'Invalid Nounce');
		} else if($type == 'refund' && refund($data['id'], $charges)) {
			$response = array('status' => 'success', 'message' => 'Refund Successful');
		} else if($type == 'refund') {
			$response = array('status' => 'error', 'message' => 'Unable To Peform Refund');
		}
		
	} else{
		$response = array('status' => 'error', 'message' => 'Invalid Token On Purchase');
	}
	
	//JSON Encode
	$response = json_encode($response);
		
	//Return an encrypted message
	return Security::encrypt($response);
	
}, 'closure');



