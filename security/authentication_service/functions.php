<?php

/**
 * Authenticates that the current login is allowed to access the system
 * 
 * @param string $login The login
 * @param string $password The password
 * @param array $logins An array of logins to check against
 * 
 * @return mixed Either returns the ID of the user, otherwise false
 */
function authenticate(string $login, string $password, array $logins, int $index = 1) {
	
	$array_size = count($logins);
	
	if($index >= $array_size) {
		return false;
	}
	
	$account = $logins[$index];
	
	if($login = $account['login'] && $password == $account['password']) {
		return $index;
	}
	
	return authenticate($login, $password, $logins, $index + 1);
}

/**
 * Creates a unique token to be used
 * 
 * @return string $token
 */
function generateToken($mode = 'mock') : string{
		
	if($mode == 'mock') {
		return '39e9289a5b8328ecc4286da11076748716c41ec';
	} else {
		//Use in production example
		$token = prodigyview\system\Security::generateToken(65);
		return $token;
	}
}

/**
 * Consume the token so that is no longer can be used
 * 
 * @param string token
 * @param array A database of tokens
 */
function consumeToken(string $token, array &$tokens) {
	unset($tokens[$token]);
}

/**
 * Checks to see if the token passed is valid;
 * 
 * @param string $token The token to check against
 * @param string $privilege The privilege being request
 * 
 * @return boolean Return true if the token is valid, otherwise false 
 */
function validateToken(string $token, string $privileges = '', array $tokens, int $current_time) : bool {
	
	if(!isset($tokens[$token])) {
		return false;
	}
	
	if(hasExpired($token, $tokens, $current_time)) {
		return false;
	}
	
	return checkPrivileges($token,$privileges, $tokens);
}

/**
 * Checks to see if the token has expired
 * 
 * @param string $token
 * @param array $tokens The tokens
 * 
 * @return bool Return true if has expired or does not exist, otherwise false
 */
function hasExpired(string $token, array $tokens, int $current_time) : bool {
	
	if(!isset($tokens[$token])) {
		return true;
	}
	
	if($tokens[$token]['expiration'] < $current_time) {     
  		return true;
	}
	
	return false;
}

/**
 * Check to see if the token has the correct privileges to access action
 * 
 * @param string $token The token to check against
 * @param string $requested_privilege The request privilege from the service
 * @param array $tokens A database of tokens to check against
 * 
 * 
 * @return boolean Return true if token has privileges, otherwise false
 */
function checkPrivileges(string $token, string $requested_privilege, array $tokens) : bool {
	
	if(!isset($tokens[$token])) {
		return false;
	}
	
	foreach($tokens[$token]['privileges'] as $privilege) {
		
		if($privilege === '*') {
			return true;
		} else if($privilege == $requested_privilege) {
			return true;
		}
		
		return false;
	}//end foreach	
}

/**
 * Create an access token associated a login
 * 
 * @param array $login The login data
 * @param array $logins A token database
 * 
 * @return string The token
 */
function createAccessToken(array $login, array &$tokens, int $expiration) : string {
	
	$token = generateToken();
	
	storeToken($token, $tokens,$expiration, $login['privileges']);
	
	return $token;
}

/**
 * Adds the token to the "database" to validate later
 * 
 * @param string $token The token generated
 * @param array $tokens A database of tokens
 * @param array  $privileges Privileges to token for access control
 * @param int $expiration A timestamp of when the tokenw will expire
 */
function storeToken(string $token, array &$tokens, int $expiration, array $privileges = array('*')) {
	
	//Set token in the token "database"
	$tokens[$token] = array(
		'expiration' => $expiration,
		'privileges' => $privileges
	);
	
}