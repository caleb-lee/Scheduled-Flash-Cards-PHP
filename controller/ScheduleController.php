<?php
/***
 * ScheduleController class
 * Author: Caleb Lee
 *
 * This class handles all the scheduling logic within the app. Given a card ID and a 
 *	user-given difficulty, it figures out how to schedule the next showing of the card
 *	and appends the database entry.
 ***/
 
require_once(__DIR__ . '/../constants.php');
require_once(__DIR__ . '/../model/DatabaseCommunicator.php');
require_once(__DIR__ . '/../model/Card.php');

class ScheduleController {
	private $dbComm;

	public function __construct($dbCommuncator) {
		$this->dbComm = $dbCommunicator;
	}
}
 
?>