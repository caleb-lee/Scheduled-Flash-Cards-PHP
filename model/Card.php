<?php
/**
 * Card class
 * Author: Caleb Lee
 *
 * This class represents a flash card. It has a front (containing text),
 * a back (also containing text), an interval (amount of time in days between last seen 
 * and now) and a next see date (calculated by some controller)
 **/

class Card {
	public $front;
	public $back;
	public $interval = 0;
	public $lastSeenDate = '2000-01-01';
	public $nextDate = '0';
	public $cardID = -1; // database ID for card; default is -1 because it will never appear in the DB
	
	public function __construct($front, $back) {
		$this->front = $front;
		$this->back = $back;
		
		$this->nextDate = date("Y-m-d");
	}
}

?>