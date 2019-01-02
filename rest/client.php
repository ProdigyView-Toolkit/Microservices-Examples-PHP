<?php

include('vendor/autoload.php');

use prodigyview\network\Curl;


$host = '127.0.0.1:8080';

$curl = new Curl($host);
$curl-> send('get',array('GET' => 'FIND'));
echo $curl->getResponse();
echo "\n";

$curl = new Curl($host);
$curl-> send('post',array('POST' => 'CREATE'));
echo $curl->getResponse();
echo "\n";

$curl = new Curl($host);
$curl-> send('put',array('PUT' => 'UPDATE'));
echo $curl->getResponse();
echo "\n";

$curl = new Curl($host);
$curl-> send('delete',array('DELETE' => 'DELETE'));
echo $curl->getResponse();
echo "\n";


