<?php
include ('vendor/autoload.php');

use prodigyview\network\Curl;
use prodigyview\network\Socket;
use prodigyview\system\Security;


echo "\nStarting Route Speed Tests\n\n";

$request = 100;
$data = array('test' => 'string','ofdata' => 'to send');
Security::init();

$start = microtime(true);
for($i =0; $i<$request; $i++) {
	$curl = new Curl('127.0.0.1:8000/callme');
	$curl->send('get',$data );
	$curl->getResponse();
}

echo 'HTTP Routing Time: ' . (microtime(true) - $start) . "\n";


$start = microtime(true);
for($i =0; $i<$request; $i++) {
	$curl = new Curl('http://127.0.0.1:8000/get.php');
	$curl->send('get',$data );
	$curl->getResponse();
}

echo 'HTTP GET Time (No Routing): ' . (microtime(true) - $start) . "\n";

$start = microtime(true);
for($i =0; $i<$request; $i++) {
	//Connect To Server 1, send message
	$socket = new Socket('localhost', 8650, array('connect' => true));
	$message = Security::encrypt(json_encode($data));
	$response = $socket->send($message);
	$socket->close();
}

echo 'Socket Test Time: ' . (microtime(true) - $start) . "\n";



