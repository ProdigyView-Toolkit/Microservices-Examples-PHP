<?php
include ('vendor/autoload.php');

use prodigyview\media\Video;
use prodigyview\util\FileManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

//Start RabbitMQ Server
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('video_queue', 	//$queue - Either sets the queue or creates it if not exist
						false,			//$passive - Do not modify the servers state
						true,			//$durable - Data will persist if crash or restart occurs
						false,			//$exclusive - Only one connection will usee, and deleted when closed
						false			//$auto_delete - Queue is deleted when consumer is no longer subscribes
						);

/**
 * Define the callback function
 */
$callback = function($msg) {
	//Convert the data to array
	$data = json_decode($msg->body, true);

	//Detect if wget and ffmpeg are installed
	exec("man wget", $wget_exist);
	exec("man ffmpeg", $ffmpeg_exist);

	if ($wget_exist) {
		//Use wget to download the video.
		exec("wget -O video.mp4 {$data['video_url']}");
	} else {
		//Use ProdigyView's FileManager as backup
		FileManager::copyFileFromUrl($data['video_url'], getcwd() . '/', 'video.mp4');
	}

	if ($ffmpeg_exist) {
		//Run a conversion using ffmpeg
		Video::convertVideoFile('video.mp4', 'video.' . $data['convert_to']);
	} else {
		echo "Sorry No Conversion Software Exist On Server\n";
	}

	echo "Finished Processing\n";
};

//Pass the callback
$channel->basic_consume('video_queue', '', false, false, false, false, $callback);

//Listen to requests
while (count($channel->callbacks)) {
	$channel->wait();
}
