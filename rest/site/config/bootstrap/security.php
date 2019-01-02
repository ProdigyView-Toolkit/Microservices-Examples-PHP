<?php
/**
 * Configure the options for the Security class. Remember to set the options for the encryption,
 * salt, and authorization.
 */
use prodigyview\system\Security;
use prodigyview\system\Database;

$security_config = array(		
	'mcrypt_key' => '8v9Fp.',									//Set the encryption key
	'mcrypt_iv' => '3n9zAPQ3',									//Set the encryption ov
	'salt' => '$1$ef0110101',									//Set the salt used for password
	'cookie_fields' => array('user_id'),							//Set the fields to be saved to a cookie on successful authentication
	'session_fields' => array('user_id'),						//Set the fields to be saved to a session on successful authentication
	'auth_hashed_fields' => array('user_password'),				//Hash these fields with the salt
	'auth_table' => Database::formatTableName('users')			//The collection to be used when authentication
);

Security::init($security_config);
