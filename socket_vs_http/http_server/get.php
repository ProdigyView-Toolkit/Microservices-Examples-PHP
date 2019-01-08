<?php
include_once (dirname(__FILE__) . '/../vendor/autoload.php');

use prodigyview\network\Response;

$response = array('status' => 'success', 'message' => 'Responding');
echo Response::createResponse(200, json_encode($response));