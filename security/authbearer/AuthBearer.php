<?php
/**
 * The AuthBearer is a class that encapsulates the responsibilities
 * of getting and recieiving a token.
 */
use prodigyview\network\Socket;
use prodigyview\system\Security;
 
class AuthBearer {
	
	/**
	 * Gets the token from the authentication servicer
	 * 
	 * @param string $login
	 * @param string $password
	 * 
	 * @return mixed Returns the token if successful, otherwise false
	 */
	public static function getToken(string $login, string $password){
		
		//Special socket that goes to our authentication service
		$socket = new Socket('localhost', 8600, array('connect' => true));
	
		//JSON encode a message requesting a token and sending the login and password
		$message = json_encode(array('login'=> $login, 'password' => $password, 'request' => 'authenticate'));
		
		//Encrypt The Message
		$message = Security::encrypt($message);
		
		//Send Data To Email Processing
		$result = $socket->send($message);
	
		//Decrypt the Encrypted message
		$result = Security::decrypt($result);

		//Close the conection
		$socket->close();
		
		$response = json_decode($result, true);
		
		if(isset($response['error'])) {
			return false;
		} else {
			return $response['token'];
		}
	}
	
	/**
	 * Checks to see if the token has the correct access with the associated action.
	 * 
	 * @param string $token
	 * @param string $action
	 * 
	 * @return bolean Returns true if the token is valid, otherwise false
	 */
	public static function hasAccess(string $token, string $action){
		
		//Special socket that goes to our authentication service
		$socket = new Socket('localhost', 8600, array('connect' => true));
	
		//JSON encode a message requesting a token and sending the login and password
		$message = json_encode(array('token'=> $token,'request' => 'authorize', 'action' => $action));
		
		//Encrypt The Message
		$message = Security::encrypt($message);
		
		//Send Data To Email Processing
		$result = $socket->send($message);
	
		//Decrypt the Encrypted message
		$result = Security::decrypt($result);

		//Close the conection
		$socket->close();
		
		$response = json_decode($result, true);
		
		if(isset($response['error'])) {
			return false;
		} else {
			return true;
		}
	}
	
}