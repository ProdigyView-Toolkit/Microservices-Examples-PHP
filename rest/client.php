<?php

include('vendor/autoload.php');

use prodigyview\network\Curl;


$host = '127.0.0.1:8080/server.php';

echo "\nStarting RESTFUL Tests\n\n";

//Retrive All Stories
$curl = new Curl($host);
$curl-> send('get');
echo $curl->getResponse();
echo "\n\n";

//Retrieve A Single Story
$curl = new Curl($host);
$curl-> send('get', array('id'=>1));
echo $curl->getResponse();
echo "\n\n";

//Unsuccessful Post
$curl = new Curl($host);
$curl-> send('post',array('POST' => 'CREATE'));
echo $curl->getResponse();
echo "\n\n";

//Successfully Creates A Story
$curl = new Curl($host);
$curl-> send('post',array('title' => 'Robin Hood', 'description' => 'Steal from the rich and give to me.'));
echo $curl->getResponse();
echo "\n\n";

//Successfully Updates A Story
$curl = new Curl($host);
$curl-> send('put',array('id' => '2', 'title' => 'All About Me'));
echo $curl->getResponse();
echo "\n\n";

//Unsuccessfuly Deletes A Story
$curl = new Curl($host);
$curl-> send('delete',array('delete' => 'me'));
echo $curl->getResponse();
echo "\n\n";

//Successfuly Deletes A Story
$curl = new Curl($host);
$curl-> send('delete',array('id' => 1));
echo $curl->getResponse();
echo "\n\n";


