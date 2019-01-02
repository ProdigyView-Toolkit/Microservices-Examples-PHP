<?php
use prodigyview\template\Template;
use prodigyview\system\Session;

//This is a filter add is added to the template error message and success message. It negates
//the return thus altering the functions output
Template::addFilter('prodigyview\template\Template','errorMessage', 'Alert', 'addAlert', array('event'=>'return'));
Template::addFilter('prodigyview\template\Template','successMessage', 'Alert', 'addAlert', array('event'=>'return'));

/**
 * Alert is a library that is loaded with the MVC Helium. The purpose of alert is to provide
 * messages that can persist between page changes.
 */
class Alert {
	
	private static $alert_count = 0;
	
	/**
	 * Method takes the data filtered from Template::errorMessage and Template::successMessage
	 * and adds the output to a session that is later called in the template.
	 * 
	 * @param string $message The message passed to the addAlert
	 * @param array $options Options passed about the filter
	 * 
	 * @return void
	 * @access public
	 */
	public static function addAlert($message, $options) {
		
		$he2_alerts = Session::readSession('he2_alerts');
		
		if(empty($he2_alerts))
			$he2_alerts = array();		
		
		$he2_alerts[] = $message;
		
		Session::writeSession('he2_alerts', $he2_alerts );
	}
	
}
