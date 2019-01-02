<?php
/**
 * Initialize the template class. This class is responsible for messages displayed to the user, displaying
 * javascript and css, and the overall process of the view. 'Template' uses aspects of 'Template' but they
 * are seperate classes,
 */
 
 use prodigyview\template\Template;

$template_options = array();
Template::init($template_options);

//**Set the Default Site Title
Template::setSiteTitle('My Website');

/**
 * Adds an adapter to overrwrite the default method Template::_titleCheck and
 * write out the title of site in a different way.
 * 
 * Adapters are an example of aspect oritented programming and an alternative to dependency injection 
 */
Template::addAdapter('prodigyview\helium\He2Template', '_titleCheck', function($view) {
	
	$title = Template::getSiteTitle();
	
	if($title == 'My Website' && !($view['view'] == 'index' && $view['prefix'] == 'index')) {
			
		if($view['prefix'] == 'index')
			$view['prefix'] = 'main';
		
		$view['prefix'] = ucwords($view['prefix']); 
		$view['view'] = ucwords($view['view']); 
		
		Template::setSiteTitle('My Website - ' . $view['view']. ' - '. $view['prefix'] );
	}
} , array('type' => 'closure'));
