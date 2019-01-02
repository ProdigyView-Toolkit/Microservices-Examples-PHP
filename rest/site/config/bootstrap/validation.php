<?php
/**
 * The validator is used for validation of input data. Initialize, configure and add custom rules
 * to the validator below. Validation is primarly used in conjunction with a model but can also
 * be used in standalone validation.
 * 
 */
use prodigyview\util\Validator;

//Initialize validation class
Validator::init(array());

/**
 * Compares what should be passed is an of a user and compares it the id of the user
 * that currently has a session in the cookie
 */
$differentUser = function($value) {
	return !($value == Session::readCookie('user_id'));
};

Validator::addRule('differentUser', array('function' => $differentUser));


/**
 * Cast the passed value to an array if it is not already one, and the checks to make
 * sure that the array is not empty.
 */
Validator::addRule('notEmptyArray', array('function' => function(array $value) {
	return !empty($value);
}));


/**
 * Validation rule that checks to make sure the uploaded image is an image. Retrieves the mime type
 * of the image using FileManager::getMimeType, and uses Validator::isImageFile that checks
 * mime types.
 */
Validator::addRule('checkImageUpload', array('function' => function($file){
	
	$validation = false;
	
	if($file['size'] > 0 && Validator::isImageFile(FileManager::getFileMimeType($file['tmp_name'])))
		$validation = true;
	
	return $validation;
}));

/**
 * In the lengthCheck example, the validation is defined directly in the 'addRule' method.
 * This validation takes in options that would be sent from the model if specified.
 */
Validator::addRule('lenghtCheck', array('function' => function($string, $options) {
	$valid = true;
	
	if(isset($options['min']) && strlen($string) < $options['min'])
		$valid = false;
	
	if(isset($options['max']) && strlen($string) > $options['max'])
		$valid = false;
		
	return $valid;
}));


/**
 * Add a rule to ensure that the passed value does not equal zero. Used to different the
 * difference between empty and zero
 */
Validator::addRule('notzero', array('function' => function($value) {
	if($value != 0)
		return true;
	
	return false;
}));


/**
 * Checks to see if the file has an image extension.
 */
Validator::addRule('is_image_file', array('function' => function($file) {
	
	if(!file_exists($file))
		return false;
	
	$mime_type = FileManager::getFileMimeType($file);
	
	return Validator::isImageFile($mime_type);
}));







