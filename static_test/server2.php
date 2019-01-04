<?php
include('vendor/autoload.php');

use prodigyview\network\Socket;
use prodigyview\system\Security;

//Create a socket for server 2
$server = new Socket('127.0.0.1', 8021, array(
	'bind' => true,
	'listen' => true
));

//Simple class that print Foobar
class PrintFoobar {
	
	public static function fooBar() {
		
	}
}

//Start the server, code is executed in closure
$server->startServer('', function($message) {
	
	PrintFoobar::fooBar();
	
	return '';
	
}, 'closure');
