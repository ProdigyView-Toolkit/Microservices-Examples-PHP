<?php

namespace app\services;

use prodigyview\system\Session;
use prodigyview\system\Security;
/**
 * SessionService
 * 
 * This class handles Session by storing them in a cookie and/or session. The cookie data is
 * encrypted to help with security.
 */
class SessionService {
	
	//Determines of the Session should be saved in a cookie
	private static $_write_to_cookie = true;
	
	/**
	 * Boots that session but does nothing special.
	 */
	public static function initializeSession($write_to_cookie = true) {
		
		self::$_write_to_cookie= $write_to_cookie;
		return get_class();
	}
	
	/**
	 * Reads a session if it is set.
	 * 
	 * @param string $key The key to access the data
	 * 
	 * @return mixed The found value or false
	 */
	public static function read($key) {
		
		$value = Session::readCookie($key);
		
		if(!$value) {
			$value = Session::readSession($key);
		}
		
		return ($value) ? Security::decrypt($value) : false;
	
	}
	
	/**
	 * Writes a session to the cookie
	 * 
	 * @param string $key The key to finding the data later
	 * @param string $value The value to store in the cookie
	 * 
	 * 
	 */
	public static function write($key, $value){
		
		if(!$value) {
			return false;
		}
		
		$value = Security::encrypt($value);
		
		if(self::$_write_to_cookie) {
			Session::writeCookie($key, $value);
		}
		
		Session::writeSession($key, $value);
	}
	
	/**
	 * Gets the id of the current session
	 * 
	 * @return string
	 */
	public static function getID() {
		return session_id();
	}
	
	/**
	 * Does nothing because there is no need to refresh data
	 * kept in the browser
	 * 
	 * @return void
	 */
	public static function refresh() : void {
		
	}
	
	/**
	 * Destroys the session, logging the user out
	 */
	public static function endSession() {
		setcookie('session_id', NULL, time() - 4800);
	    session_unset();
	    session_destroy();
	    session_write_close();
	    setcookie(session_name(),'',0,'/');
		
		if(session_id()) {
	    		session_regenerate_id(true);
		}
		
		if(isset($_SESSION) && session_id()) {
    			session_destroy();
		}
	}
	
}
