<?php

include('baseController.php');

use prodigyview\template\Template;
use prodigyview\network\Router;
use prodigyview\network\Request;
use prodigyview\network\Response;

class indexController extends baseController {
	

	public function index() : array  {
		
		$request = new Request();
		
		$method = strtolower($request->getRequestMethod());
		
		$data = $request->getRequestData('array');
		
		if($method == 'get') {
			$this ->get($data); 
		} else if($method == 'post') {
			$this ->post($data); 
		} else if($method == 'put') {
			$this ->put($data); 
		} else if($method == 'delete') {
			$this ->delete($data); 
		}
		
		exit();
		
		return array();
	}
	
	private function get($data) {
		$data = array(
			'message' => 'Query Content',
			'data' => $data
		);
		echo Response::createResponse(200,json_encode($data));
		exit();
	}
	
	private function post($data) {
		$data = array(
			'message' => 'Created  Content',
			'data' => $data
		);
		echo Response::createResponse(200,json_encode($data));
		exit();
		
	}
	
	private function put($data) {
		$data = array(
			'message' => 'Update Content',
			'data' => $data
		);
		echo Response::createResponse(200,json_encode($data));
		exit();
		
	}
	
	private function delete($data) {
		$data = array(
			'message' => 'Delete Content',
			'data' => $data
		);
		echo Response::createResponse(200,json_encode($data));
		exit();
		
	}
	
	
	
}
