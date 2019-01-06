<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once (dirname(__FILE__) . '/../payment_server/functions.php');

final class PaymentTest extends TestCase {
	
	private $_charges = array(
		'123456'=> array(
			'amount' => '10',
			'status' => 'charged',
			'meta' => array('product_id'=> 'x3c3', 'account_id'=>1)
		),
		'789012'=> array(
			'amount' => '20',
			'status' => 'refunded',
			'meta' => array('product_id'=> 'c8d0', 'account_id'=>2)
		),
	);
	
	private $_nounces = array(
		'1c46538c712e9b5bf0fe43d692',
		'004f617b494d004e29daaf'
	);
	
	public function testNounceExistTrue() {
		
		$result = checkNounce('1c46538c712e9b5bf0fe43d692', $this -> _nounces);
		
		$this->assertTrue($result);
	}
	
	public function testNounceExistFalse() {
		
		$result = checkNounce('abc123', $this -> _nounces);
		
		$this->assertFalse($result);
	}
	
	public function testChargeExistTrue() {
		
		$result = chargeExist('123456', $this->_charges);
		
		$this->assertTrue($result);
		
	}
	
	public function testChargeExistFalse() {
		
		$result = chargeExist('doe123P', $this->_charges);
		
		$this->assertFalse($result);
		
	}
	
	public function testChargeExistAfterPayment() {
		$result = charge(5.00, 'abc123', array('product' => 'radio1'), $this->_charges);
		
		$this->assertTrue(chargeExist($result, $this->_charges));
	}
	
	public function testRefundTrue() {
		$refunded = refund('123456', $this->_charges);
		
		$this->assertTrue($refunded);
	}
	
	public function testRefundFalse() {
		$refunded = refund('789012', $this->_charges);
		
		$this->assertFalse($refunded);
	}
	
	
	
		
}
	