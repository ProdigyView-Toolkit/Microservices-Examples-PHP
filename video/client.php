<?php

include ('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

//Create the queue
$channel->queue_declare('video_queue', 	//$queue - Either sets the queue or creates it if not exist
						false,			//$passive - Do not modify the servers state
						true,			//$durable - Data will persist if crash or restart occurs
						false,			//$exclusive - Only one connection will use queue, and deleted when closed
						false			//$auto_delete - Queue is deleted when consumer is no longer subscribes
						);

$data = array(
	'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_20mb.mp4',
	'convert_to' => 'mov'
);

//Create the message, set the delivery to be persistant for crashes and restarts
$msg = new AMQPMessage(json_encode($data), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
$channel->basic_publish($msg, '', 'video_queue');

echo "Sent Video To Server!'\n";

$channel->close();
$connection->close();
