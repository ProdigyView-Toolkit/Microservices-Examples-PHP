<?php
include('vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\system\Security;

//Mock sender data
$data = array('No'=> 'DATA');

//JSON encode the message
$message = json_encode($data);

$request = 5000;

$start = microtime(true);
for($i =0; $i<$request; $i++) {
	//Connect To Server 1, send message
	$socket1 = new Socket('127.0.0.1', 8020, array('connect' => true));
	$response = $socket1->send($message);
}

echo 'Server 1: ' . (microtime(true) - $start) . "\n";
$socket1->close();

$start = microtime(true);
for($i =0; $i<$request; $i++) {
	//Connect To Server 2, send message
	$socket2 = new Socket('127.0.0.1', 8021, array('connect' => true));
	$response = $socket2->send($message);
}

echo 'Server 2: ' . (microtime(true) - $start) . "\n";
$socket2->close();



