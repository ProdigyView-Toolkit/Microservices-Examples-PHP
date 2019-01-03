<?php

include ('vendor/autoload.php');

use prodigyview\media\Video;
use prodigyview\util\FileManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;

//Start RabbitMQ Server
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('video_queue', false, false, false, false);

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
		exec("wget {$data['video_url']} -O video.mp4");
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
$channel->basic_consume('video_queue', '', false, true, false, false, $callback);

//Listen to requests
while (count($channel->callbacks)) {
	$channel->wait();
}
