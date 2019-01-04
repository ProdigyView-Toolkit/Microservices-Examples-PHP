<?php
include ('vendor/autoload.php');

use prodigyview\network\Curl;

$article_route = '127.0.0.1:8090/articles';

$notifications_route = '127.0.0.1:8090/notifications';

$media_route = '127.0.0.1:8090/media';

echo "\nStarting RESTFUL Tests\n\n";

echo "Testing Notificatons\n\n";

//Error From Notification
$curl = new Curl($notifications_route);
$curl->send('get');
echo $curl->getResponse();
echo "\n\n";

//Attempts To Send Email
$curl = new Curl($notifications_route);
$curl->send('post', array(
	'to' => 'Jane Doe',
	'email' => 'jane@example.com',
	'message_html' => 'Jane You Rock',
	'message_text' => 'Jane You Rock'
));
echo $curl->getResponse();
echo "\n\n";

//Attempts To Send Push Notification
$curl = new Curl($notifications_route);
$curl->send('put', array(
	'payload' => array('type'=>'pop_up', 'message'=> 'Hello World'),
	'device_token' => 'abc123',
));
echo $curl->getResponse();
echo "\n\n";

echo "Media\n\n";

//Send Image To Be Processed
$curl = new Curl($media_route);
$curl->send('put', array(
	'url' => 'https://images.unsplash.com/photo-1546441201-69837cbe526c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80',
));
echo $curl->getResponse();
echo "\n\n";


//Send Video To Be Processed
$curl = new Curl($media_route);
$curl->send('post', array(
	'url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_20mb.mp4',
	'convert_to' => 'mov',
 ));
echo $curl->getResponse();
echo "\n\n";

echo "Testing The Articles\n\n";

//Retrive All Stories
$curl = new Curl($article_route);
$curl->send('get');
echo $curl->getResponse();
echo "\n\n";

//Retrieve A Single Story
$curl = new Curl($article_route);
$curl->send('get', array('id' => 1));
echo $curl->getResponse();
echo "\n\n";

//Unsuccessful Post
$curl = new Curl($article_route);
$curl->send('post', array('POST' => 'CREATE'));
echo $curl->getResponse();
echo "\n\n";

//Successfully Creates A Story
$curl = new Curl($article_route);
$curl->send('post', array(
	'title' => 'Robin Hood',
	'description' => 'Steal from the rich and give to me.'
));
echo $curl->getResponse();
echo "\n\n";

//Successfully Updates A Story
$curl = new Curl($article_route);
$curl->send('put', array(
	'id' => '2',
	'title' => 'All About Me'
));
echo $curl->getResponse();
echo "\n\n";

//Unsuccessfuly Deletes A Story
$curl = new Curl($article_route);
$curl->send('delete', array('delete' => 'me'));
echo $curl->getResponse();
echo "\n\n";

//Successfuly Deletes A Story
$curl = new Curl($article_route);
$curl->send('delete', array('id' => 1));
echo $curl->getResponse();
echo "\n\n";
