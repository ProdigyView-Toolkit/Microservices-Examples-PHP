<?php
/**
 * Custom Validation Rules
 * 
 * The models uses Validator for check input, but Validator is limited. Below are
 * examples of how to add customized validated rules that can be checked against
 * in the models.
 */
use app\models\uuid\Users;

use prodigyview\util\Validator;
use prodigyview\util\FileManager;


/**
 * Checks to make sure a field is either empty or a complete url.
 */
Validator::addRule('url_allow_empty', array('function' => function($url) {
	
	$url = trim($url);
	
	if(!$url) {
		return true;
	}

	return Validator::isValidUrl($url);
	
}));

/**
 * Checks the database to see if a user has already
 * registered with the account.
 */
Validator::addRule('unique_email', array('function' => function($email) {

	$email = strtolower(trim($email));
	
	$user = new Users();
	$conditions = array('email' => $email);
	$user->first(compact('conditions'));
	
	if(!$user-> user_id)
		return true;
	
	return false;
}));

/**
 * Checks to ensure if an integer  or if the value is empty.
 */
Validator::addRule('integer_not_required', array('function' => function($integer) {

	if(!$integer) {
		return true;
	}
	
	return Validator::isInteger($integer);
}));

/**
 * Checks to ensure if an double  or if the value is empty.
 */
Validator::addRule('double_not_required', array('function' => function($integer) {

	if(!$integer) {
		return true;
	}
	
	return Validator::isDouble($integer);
}));

Validator::addRule('is_image_file', array('function' => function($file) {
	
	if(!file_exists($file))
		return false;
	
	$mime_type = FileManager::getFileMimeType($file);
	
	return Validator::isImageFile($mime_type);
}));


Validator::addRule('active_user', array('function' => function($email) {

	return Session::read('account_active');
}));

/*Checks to esure an input is of the minimum length*/
Validator::addRule('min_length', array('function' => function($value, $options) {
	
	if(isset($options['min'])){
		if(strlen($value) > $options['min']) {
			return true;
		}
	}
	
	return false;
}));

/**
 * Checks if the value is a currency.
 */
Validator::addRule('is_currency', array('function' => function($number) {

	return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
}));





