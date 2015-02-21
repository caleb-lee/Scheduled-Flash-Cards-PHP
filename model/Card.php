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
	private $interval = 0;
	private $lastSeenDate = '0';
	private $nextDate = '0';
	
	public function __construct($front, $back) {
		$this->front = $front;
		$this->back = $back;
	}
}

?>