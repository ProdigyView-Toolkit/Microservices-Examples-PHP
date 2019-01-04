<?php
include (dirname(__FILE__) . '/../vendor/autoload.php');

use prodigyview\media\Video;
use prodigyview\media\Image;
use prodigyview\util\FileManager;
use prodigyview\util\Validator;
use PhpAmqpLib\Connection\AMQPStreamConnection;

use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

//Start RabbitMQ Server
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
$channel = $connection->channel();

//Create The Queues to listen too
$channel->queue_declare('video_processing', false, true, false, false);
$channel->queue_declare('image_processing', false, true, false, false);


/**
 * Execute the callback for video processing
 */
$channel->basic_consume('video_processing', '', false, false, false, false, function($msg) {
	//Convert the data to array
	$data = json_decode($msg->body, true);

	if ($file = download_file($data['url'])) {
		
		echo "Converting Video....\n";

		//Rename file with extension
		$new_file = $file . getExtenstion($file);
		rename($file, $new_file);

		exec("man ffmpeg", $ffmpeg_exist);

		if ($ffmpeg_exist) {
			//Run a conversion using ffmpeg
			Video::convertVideoFile('video.mp4', 'video.' . $data['convert_to']);
		} else {
			echo "Sorry No Conversion Software Exist On Server\n";
		}
		
		//Upload to Cloud
		//uploadToStorage($new_file);
	}

	echo "Finished Converting Video\n";
});

/**
 * Execute The Callback For Image Processing
 */
$channel->basic_consume('image_processing', '', false, false, false, false, function($msg) {
	//Convert the data to array
	
	$data = json_decode($msg->body, true);
	
	if ($file = download_file($data['url'])) {
		echo "Converting Image....\n";

		//Rename file with extension
		$new_file = $file . getExtenstion($file);
		rename($file, $new_file);

		if (class_exists("Imagick")) {
			//If Imagic Installed, Add A Watermark
			$image = Image::watermarkImageWithText($new_file, 'Hello Puppy');
			$image->writeImage($new_file);
		} else {
			//If No Imagic, Just Reize It
			Image::resizeImageGD($new_file, $new_file, 200,  200);
		}
		
		//Upload to Cloud
		//uploadToStorage($new_file);

	}

	echo "Finished Processing\n";
});

/**
 * Download the file from a server
 */
function download_file(string $file) {
	//Detect if wget and ffmpeg are installed
	exec("man wget", $wget_exist);

	//Get file name from url and save to unique name
	$filename = uniqid('file_', false);

	if ($wget_exist) {
		//Use wget to download the video.
		exec("wget -O {$filename} {$file}");
	} else {
		//Use ProdigyView's FileManager as backup
		FileManager::copyFileFromUrl($file, getcwd() . '/', $filename);
	}

	if (file_exists(getcwd() . '/' . $filename)) {
		return getcwd() . '/' . $filename;
	}

	return false;
}

/**
 * Retrieves the exenstion of the downloaed file
 */
function getExtenstion(string $file) {
	$extension = pathinfo($file, PATHINFO_EXTENSION);
	
	//If pathinfo was unable to find it, brute force find by mime_type
	if (!$extension) {
		
		$mime_type = FileManager::getFileMimeType($file);
		
		Validator::init();
		
		if (Validator::check('image_file', $mime_type)) {
			
			if (Validator::check('jpg_file', $mime_type)) {
				$extension = '.jpg';
			} else if (Validator::check('png_file', $mime_type)) {
				$extension = '.png';
			} else if (Validator::check('gif_file', $mime_type)) {
				$extension = '.gif';
			}
		} else if (Validator::check('video_file', $mime_type)) {
			
			if (Validator::check('mpeg_file', $mime_type)) {
				$extension = '.mpeg';
			} else if (Validator::check('mov_file', $mime_type)) {
				$extension = '.png';
			} else if (Validator::check('avi_file', $mime_type)) {
				$extension = '.avi';
			} else if (Validator::isMp4File($mime_type)) {
				$extension = '.mp4';
			} else if (Validator::check('ogv_file', $mime_type)) {
				$extension = '.ogv';
			}
		}

	}
	
	return $extension;
}

/**
 * Upload the file to AmazonS3
 */
function uploadToStorage(string $file) {
	
	$s3 = S3Client::factory(array(
		'credentials' => array(
			'secret' => '<secret>',
			'key' => '<key>'
		),
		'region' => 'us-west-2',
		'version' => '2006-03-01',
		'timeout' => 12000,
	));
	
	//Upload in Chunks, not the whole file
	$uploader = new MultipartUploader($s3, $body, [
		'bucket' => '<bucket>',
		'key'    => $file,
		'acl'    => 'public-read',
		'concurrency' => 2,
		'part_size' => (50 * 1024 * 1024),
	]);
								
	$result = $uploader->upload();
	
	return (isset($result['Location'])) ? $result['Location'] : false;
	
}

//Listen to requests
while (count($channel->callbacks)) {
	$channel->wait();
}
