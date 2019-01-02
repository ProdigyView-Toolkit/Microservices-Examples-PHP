<?php
namespace app\models;


/**
 * Users
 * 
 * The users class is that defines the action of a user. Probably the most complex and involved model
 * in the system. All user information should coordinate with the Slack.
 */
class Users extends HModel {
	
	//Virtual Schema
	protected $_schema = array(
		'user_id' => array('type' => 'int', 'primary_key' => true, 'auto_increment' => true),
		'first_name' => array('type' => 'string', 'precision' =>255, 'default' => '', 'cast' => 'sanitize'),
		'last_name' => array('type' => 'string', 'precision' =>255, 'default' => '', 'cast' => 'sanitize'),
		'email' => array('type' => 'string', 'precision' =>255, 'default' => '', 'cast' => 'sanitize'),
		'bio' => array('type' => 'text', 'cast' => 'sanitize_wysiwyg_ahref'),
		'date_registered' => array('type' => 'datetime'),
		'is_active' => array('type' => 'tinyint', 'default' => 0),
		'activation_token' => array('type' => 'string', 'precision' =>255, 'default' => ''),
	);
	
	//Checks against the virtual schema
	protected $_validators = array(
		'first_name' => array(
			'notempty' => array('error' => 'First name is required.'),
		), 
		'last_name' => array(
			'notempty' => array('error' => 'Last name is required.'),
		), 
		'password' => array(
			'notempty' => array(
				'error' => 'Password is required to register.',
				'event' => array('create')
			),
		),
		'email' => array(
			'notempty' => array('error' => 'Email name is required.'),
			'email'=>array(
				'error'=>'A valid email address is required.',
			),
			'unique_email' => array(
				'error' => 'Email address is already registered. Please login or use the forgot password',
				'event' => array('create')
			)
		),
		
	);
	
	//How to join this model with other models
	protected $_joins = array(
		'post' => array('type' => 'join', 'model' => 'app\models\Posts', 'on' => 'users.user_id = posts.user_id'), //JOIN posts ON users.user_id = posts.user_id
		'password' => array('type' => 'natural', 'model' => 'app\models\UserPasswords'), //NATURAL JOIN user_passwords
		'image' => array('type' => 'join', 'model' => 'app\models\Images', 'on' => 'users.user_id = images.entity_id AND entity_id=\'user\' '),
		'image_left' => array('type' => 'left', 'model' => 'app\models\Images', 'on' => 'users.user_id = images.entity_id AND entity_type=\'user\' ')
	);
	
	
	
}//end class

//Data to filter on the creation of the user.
Users::addFilter('app\models\Users', 'create','filter', function($data, $options) {
	
	//Generate a random string for their activation token
	$data['data']['activation_token'] = \Tools::generateRandomString();
	
	//Set date registered
	$data['data']['date_registered'] = date("Y-m-d H:i:s");
	
	//Format the email by making it lowercase and trimming white space
	if(isset($data['data']['email'])) {
		$data['data']['email'] = strtolower(trim($data['data']['email']));
	}
	
	//Return data to normal operations
	return $data;
	
}, array('type' => 'closure', 'event' => 'args'));


//Observer to be executed after CRUD create operation
Users::addObserver('app\models\Users::create', 'read_closure', function($model, $result, $id, $data, $options) {
	
	//Only execute if successful
	if($result){
		
	
	} else {
		
	}
	
}, array('type' => 'closure'));