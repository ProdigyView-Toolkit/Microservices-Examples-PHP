<?php

include('vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\system\Security;

//Mock sender data
$data = array(
	'to' => 'Jane Doe',
	'email' => 'jane@example.com',
	'subject' => 'Hello Jane',
	'message_html'=> '<p>Dear Jane</p><p>You Are The Best!</p>',
	'message_text'=> 'Dear Jane, You Are The Best!',
);

//Add Token To Check
$data['token'] = 'ABC123-NotRealToken';

//JSON encode the message
$message = json_encode($data);

//Encrypt The Message
Security::init();
$message = Security::encrypt($message);

//Send The Message To Our Server
$host = '127.0.0.1';
$port = 8002;
$socket = new Socket($host, $port, array('connect' => true));

$response = $socket->send($message);

$response = Security::decrypt($response);

echo "$response \n";
