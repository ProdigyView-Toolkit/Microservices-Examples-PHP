<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once (dirname(__FILE__) . '/../authentication_service/functions.php');

final class AuthenticationTest extends TestCase {
	
	private $_logins = array(
		'1'=> array('login' =>'user1', 'password'=>'abc123' , 'privileges' => array('*')),
		'2'=> array('login' =>'user2', 'password'=>'123456' , 'privileges' => array('send_notification', 'send_email')),
		'3'=> array('login' =>'user3', 'password'=>'qwerty', 'privileges' => array('videos', 'images')),
	);
	
	private $_tokens = array();
	
	public function testAuthenticationPass() {
		
		$id = authenticate('user1', 'abc123', $this ->_logins);
		
		$this->assertEquals(1, $id);
	}
	
	public function testAuthenticationFail() {
		
		$id = authenticate('user1', 'abc1234', $this ->_logins);
		
		
		$this->assertFalse($id);
	}
	
	public function testTokenGeneration() {
		$token = generateToken(false);
		
		$this->assertTrue(true);
	}
	
	public function testStoringToken() {
		
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'));
		
		
		$this->assertTrue(isset($this->_tokens[$token]));
	}
	
	public function testConsumingToken() {
		
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'));
		
		consumeToken($token, $this->_tokens);
		
		$this->assertFalse(isset($this->tokens[$token]));
	}
	
	public function testHasExpiredFalse() {
		
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens,time() + 5);
		
		$expired = hasExpired($token, $this->_tokens, time());
		
		$this->assertFalse($expired);
		
		
	}
	
	public function testHasExpiredTrue() {
		
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, time() + 4);
		
		//Wait 5 seconds
		sleep(5);
		
		//Set to expire in 4 seconds
		$expired = hasExpired($token, $this->_tokens, time());
		
		$this->assertTrue($expired);
	}
	
	public function testHasPriviligesAll() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'));
		
		$hasAccess = checkPrivileges($token, 'video', $this->_tokens);
		
		$this->assertTrue($hasAccess);
	}
	
	public function testHasPriviligesVideoTrue() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'), array('video','image', 'messenging'));
		
		$hasAccess = checkPrivileges($token, 'video', $this->_tokens);
		
		$this->assertTrue($hasAccess);
	}
	
	public function testHasPriviligesVideoFalse() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'), array('image', 'messenging'));
		
		$hasAccess = checkPrivileges($token, 'video', $this->_tokens);
		
		$this->assertFalse($hasAccess);
	}
	
	public function testValidToken() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'));
		
		$hasAccess = validateToken($token, 'video', $this->_tokens, time());
		
		$this->assertTrue($hasAccess);
	}
	
	public function testValidTokenPrivilegesFalse() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, strtotime('+1 minute'), array('image', 'messenging'));
		
		$hasAccess = validateToken($token, 'video', $this->_tokens, time());
		
		$this->assertFalse($hasAccess);
	}
	
	public function testValidTokenPrivilegesExpired() {
		$token = generateToken(false);
		
		storeToken($token, $this->_tokens, time()+4, array('*'));
		
		sleep(5);
		$hasAccess = validateToken($token, 'video', $this->_tokens, time());
		
		$this->assertFalse($hasAccess);
	}
	
	
}
