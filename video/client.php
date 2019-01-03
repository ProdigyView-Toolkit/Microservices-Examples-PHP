<?php

include ('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('video_queue', false, false, false, false);

$data = array(
	'video_url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_20mb.mp4',
	'convert_to' => 'mov'
);

$msg = new AMQPMessage(json_encode($data));
$channel->basic_publish($msg, '', 'video_queue');

echo "Sent Video To Server!'\n";

$channel->close();
$connection->close();
