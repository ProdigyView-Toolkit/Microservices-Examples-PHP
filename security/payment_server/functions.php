<?php
/**
 * Checks to see if the nounce is valid.
 * 
 * @param string $nounce A nounce from the payment processor
 * @param array $nounces An array of nounces that represents the database
 */
function checkNounce(string $nounce, array $nounces) {
	
	return in_array($nounce, $nounces);
}

/**
 * Charges the purchase for an item and returns the id of the new charge
 * 
 * @param float $amount The price of theitem
 * @param string $nounce A nouce return from the payment processor
 * @param array $meta The meta information associated with the purhcase
 * @param array $charges A database that represents a lit of charges
 * 
 * @return mixed Returns the id ofthe charge
 */
function charge(float $amount, string $nounce, array $meta = array(), array &$charges) {
	
	$id = uniqid();
	
	$charges[$id] = array(
		'amount' => $amount,
		'status' => 'charged',
		'meta' => $meta
	);
	
	return $id;
}

/**
 * Refunds an item that has been purchased
 * 
 * @param string $id The id of the time that was purchased
 * @param array $charges A database array of charges
 * 
 * @return boolean Returns true of the item was deleted, otherwise false
 */
function refund($id, array &$charges) : bool {
	
	if(isset($charges[$id]) && $charges[$id]['status']=='charged')	 {
		unset($charges[$id]);
		return true;
	}
	
	return false;
	
}

/**
 * Checkes to see if a charge exist
 * 
 * @param string $id The id of a charge to check if it exist
 * @param array $charges A database of charges to check against
 * 
 * @return boolean Returns true of the charge exist, otherwise false
 */
function chargeExist($id, array &$charges) : bool {
	return isset($charges[$id]);
}
