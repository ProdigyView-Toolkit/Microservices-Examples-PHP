<?php
use app\services\LoggingService;
use prodigyview\helium\He2Controller;

use prodigyview\template\Template;
use prodigyview\network\Router;
use prodigyview\network\Request;
use prodigyview\network\Response;

/**
 * baseController
 * 
 * This is an controller that should never be accessed by the user. The controller should
 * be extended to other controllers for universal functions. 
 */
 
class baseController extends He2Controller {
	
	public function index() {
		exit();
	}
	
	/**
	 * The function to be called when the page error 404 outs. Normal causes of 404 are an object not existing
	 * or the object being registered as deleted.
	 * 
	 * @param array $data Data to be stored in the state of the log
	 * @param string $message Additonal information about the event.
	 * 
	 * @return void
	 */
	public function error404(array $data = array(), string $message = '') : array {
		header("HTTP/1.0 404 Not Found");
		
		//Changes the view to 'pages' with error404.html.php
		$this -> _renderView(array('view' => 'pages', 'prefix' => 'error404'));
		
		$controller = get_class($this);
		$action = $this -> _getStateRoute();
		$message = $this -> _formatLogMessage($message);
		
		LoggingService::logController($controller, $action, '404'.$message, $data);
		
		return array();
	}
	
	/**
	 * To be called when a page is illegally access. This normal happens when a user
	 * is not the owner of a resrouce.
	 * 
	 * @param array $data Data to be stored in the state of the log
	 * @param string $message Additonal information about the event.
	 * 
	 * @return void
	 */
	public function accessdenied(array $data = array(), string $message = '') : array {
		
		//Changes the view to 'pages' with accessdenined.html.php
		$this -> _renderView(array('view' => 'pages', 'prefix' => 'accessdenied'));
		
		$controller = get_class($this);
		$action = $this -> _getStateRoute();
		$message = $this -> _formatLogMessage($message);
		
		LoggingService::logController($controller, $action, 'Illegal Access'.$message, $data);
		
		return array();
	}
	
	/**
	 * Gets the state that is passed into the log. The state
	 * is the route that the user is currently on.
	 * 
	 * @return string
	 */
	private function _getStateRoute() : string {
		
		$route = Router::getRoute();
		$action = isset($route['action']) ? $route['action'] : '';
		
		if(!$action ) {
			$action = (Router::getRouteVariable('action')) ?: '';
		}
		
		return $action;
	}
	
	/**
	 * Formats a log message if it is not empty to have extra data.
	 * 
	 * @param string $message The message
	 * 
	 * @return $string
	 */
	private function _formatLogMessage(string $message) : string {
		
		if(trim($message)) {
			$message = ' : ' . $message;
		}
		
		return $message;
	}
	
}
