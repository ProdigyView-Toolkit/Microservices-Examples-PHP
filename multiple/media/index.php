<?php
include (dirname(__FILE__).'/../vendor/autoload.php');

use prodigyview\network\Request;
use prodigyview\network\Response;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

//Process The Current HTTP Request
$request = new Request();

//Get The Request Method(GET, POST, PUT, DELETE)
$method = strtolower($request->getRequestMethod());

//RETRIEVE Data From The Request
$data = $request->getRequestData('array');

//Connect To RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

//Route The Requests
if ($method === 'post') {
	post($data, $channel);
} else if ($method === 'put') {
	parse_str($data,$data);
	put($data, $channel);
} else {
	sendResponse(json_encode(array('status' => 'No Service Found')));
}


/**
 * Process the post request, which handles videos
 */
function post(array $data = array(), AMQPChannel $channel) {
	$queue = 'video_processing';
	$channel->queue_declare($queue, false, true, false, false);
	send(json_encode($data), $channel, $queue);
}

/**
 * Process the put request, which handles images
 */
function put(array $data = array(), AMQPChannel $channel) {
	$queue = 'image_processing';
	$channel->queue_declare($queue, false, true, false, false);
	send(json_encode($data),$channel, $queue);
}

/**
 * Sends the media to the server for process
 */
function send(string $message, AMQPChannel $channel, string $queue) {
	global $connection;
	
	$msg = new AMQPMessage($message, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
	$channel->basic_publish($msg, '', $queue);
	$channel->close();
	$connection->close();
}
