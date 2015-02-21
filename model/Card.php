<?php
/**
 * Card class
 * Author: Caleb Lee
 *
 * This class represents a flash card. It has a front (containing text),
 * a back (also containing text), an interval (amount of time in seconds between last seen 
 * and now) and a next see date (calculated by some controller)
 **/

class Card {
	public $front;
	public $back;
	public $interval = 0;
	public $lastSeenDate = '0';
	public $nextDate = '0';
	public $cardID = -1; // database ID for card
	
	public function __construct($front, $back) {
		$this->front = $front;
		$this->back = $back;
	}
}

?>