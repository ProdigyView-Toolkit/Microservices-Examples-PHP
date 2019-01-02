<?php
namespace app\models;

use prodigyview\helium\He2Model;

/**
 * HModel
 * 
 * HModel is a parent model that should be extended to all children models. It contains
 * specialized methods that make accessing data and functions easier.
 */
class HModel extends He2Model {

	//Set the configuration options for Helium's MVC. Column/Schema check should be of
	//to improve performance
	protected $_config = array('create_table' => false, 'column_check' => false, );


	/**
	 * Returns all validation errors has one unified string.
	 * 
	 * @return string
	 */
	public function getErrorsString() {
		
		$errors = $this -> getValidationErrors();
		$string = '';

		foreach ($errors as $error) {
			$string .= implode('', $error);
		}
		
		return $string;
	}

	/**
	 * A shortcut methmod for finding a single model based on the conditions passed in.
	 * 
	 * @param array $args The arguements passed in that can be used to query. Args can include
	 * 				- array $conditions: An array of conditions in the WHERE clause
	 * 				- array $join: an array
	 */
	public static function findOne(array $args = array(),array $options = array(), array $data = array()) {

		$model = self::_loadModel($data);

		$model -> first($args, $options);

		if ($model -> getIterator() -> count() === 0) {
			return null;
		} else {
			return $model;
		}

	}

	public static function findAll(array $args = array(), array $options = array(), array $data = array()) {

		$model = self::_loadModel($data);

		$model -> find($args, $options);

		if ($model -> getIterator() -> count() === 0) {
			return array();
		} else {
			return $model -> getIterator() -> getData();
		}

	}

	/**
	 * 
	 */
	public static function deleteAll(array $args = array()) {
		$model = self::_loadModel();

		return $model -> delete($args);
	}

	protected static function _loadModel(array $data = array() ) {

		$class = get_called_class();
		return new $class($data);
	}

	
	/**
	 * Cast data to a certain type. The cast option should be set in the schema in the model.
	 * 
	 * @param mixed $data The data to be casted to a different type
	 * @param string $cast A string of what to cast to the data too. The options are:
	 * 			'boolean', 'integer', 'float', 'string', 'array', 'object', 'null', 'mongoid'
	 * 
	 * @return mixed $data The data to a new casted type, if any
	 * @access protected
	 */
	protected function _castData($data, $cast) {
		
		if (self::_hasAdapter(get_class(), __FUNCTION__))
			return self::_callAdapter(get_class(), __FUNCTION__, $data, $cast);
		
		if (self::_hasAdapter(get_called_class(), __FUNCTION__))
			return self::_callAdapter(get_called_class(), __FUNCTION__, $data, $cast);
		
		$filtered = self::_applyFilter(get_class(), __FUNCTION__, array('data' => $data, 'cast' => $cast), array('event' => 'args'));
		$data = $filtered['data'];
		$cast = $filtered['cast'];
		
		$filtered = self::_applyFilter(get_called_class(), __FUNCTION__, array('data' => $data, 'cast' => $cast), array('event' => 'args'));
		$data = $filtered['data'];
		$cast = $filtered['cast'];
		
		$cast_types = array('boolean', 'integer', 'float', 'string', 'array', 'object', 'null');
		if(in_array($cast, $cast_types)){
			settype($data, $cast);
		} else if($cast === 'mongoid'){
			$data = MongoSelector::getID($data);
		} else if($cast === 'array_recursive'){
			settype($data, 'array');
			$data = \Conversions::objectToArray($data);
		} else if($cast === 'sanitize') {
			$data = self::sanitizeInput($data);
		} else if($cast === 'sanitize_wysiwyg') {
			$data = self::sanitizeInput($data, '<p><strong><b><ul><li><ol><i><blockquote><em>');
		} else if($cast === 'sanitize_wysiwyg_ahref') {
			$data = self::sanitizeInput($data, '<p><strong><b><ul><li><ol><i><blockquote><a><em>');
		} else if($cast === 'sanitize_wysiwyg_ahref_img') {
			$data = self::sanitizeInput($data, '<p><strong><b><ul><li><ol><i><blockquote><a><img><table><th><td><tr><thead><tbody><em>');
		} else if($cast === 'sanitize_wysiwyg_blog') {
			$data = self::sanitizeInput($data, '<p><br><strong><b><ul><li><ol><i><blockquote><a><img><table><th><td><tr><thead><tbody><h2><h3><h4><h5><h6><em>');
		} else if($cast === 'sanitize_wysiwyg_ad') {
			$data = self::sanitizeInput($data, '<p><br><strong><b><ul><li><ol><i><blockquote><a><img><table><th><td><tr><thead><tbody><h1><h2><h3><h4><h5><h6><em>', false, true);
		} else if($cast === 'sanitize_currency') {
			$data = str_replace(array('$', ','), '', $data);
		} else if($cast === 'sanitize_number') {
			$data = str_replace(array(','), '', $data);
		}
		
		$data = self::_applyFilter(get_class(), __FUNCTION__, $data , array('event' => 'return'));
		$data = self::_applyFilter(get_called_class(), __FUNCTION__, $data , array('event' => 'return'));
		
		return $data;
	}

	/**
	 * This function is designed to remove all formating, javascript and other elements from a string.
	 * 
	 * @param string $string The string to be sanitized
	 * @param string $allowed_tags A string of allowed html tags, ie <p><strong>
	 * @param boolean $remove_style Will remove any styling elements
	 * @param boolean $remove_class Will remove html class elements
	 * 
	 * @return string
	 */
	public static function sanitizeInput(string $string, string $allowed_tags = '', $remove_style = true, $remove_class = true) {
    
	    if(!$string) {
	      return $string; 
	    }
	    
		//Remove Javascript
	    $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
	    
	    if (function_exists('tidy_parse_string')) {
	        $tidy = tidy_parse_string($string, array(), 'UTF8');
	        $tidy -> cleanRepair();
	        $string = $tidy->value;
	    }
	    
		//Convert to TUF
	    $string = mb_convert_encoding($string, 'HTML-ENTITIES', "UTF-8");
		$string = mb_convert_encoding($string, 'UTF-8', 'ISO-8859-1');
	    
		//Walk through string to remove elements
	 	$dom = new \DOMDocument;
	    @$dom->loadHTML($string);
	    $xpath = new \DOMXPath($dom);
	    $nodes = $xpath->query('//@*');
	    
	    foreach ($nodes as $att => $node) {
	    	
			if($node && method_exists($node, 'removeAttribute')) {	
	      		//$node -> removeAttribute('style');
		  		//$node -> removeAttribute('class');
			}
	    	
			if($remove_style) {
				if($node && $node->parentNode && method_exists($node->parentNode, 'removeAttribute')) {
					$tmp = $node->parentNode -> getAttribute('style');
					if($tmp) {
		      			$node->parentNode->removeAttribute('style');
					} 		
				}
			}//end remove style
			
			
			if($remove_class) {
			
				if($node && $node->parentNode && method_exists($node->parentNode, 'removeAttribute')) {
					$tmp = $node->parentNode -> getAttribute('class');
					
					if($tmp) {
		      			$node->parentNode->removeAttribute('class');
					}
				}
			}//end remove class
	    }//end foreach
	   
	   	
	    $string = $dom->saveHTML();
	    $string = strip_tags($string, $allowed_tags);
	    
	    return trim($string);
  	}
	
	public static function sanitizeCurrency($string) {
		return str_replace(array('$', ','), '', $string);
	}

	
	
	
	
	 

}
