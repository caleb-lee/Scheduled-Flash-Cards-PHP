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
	private $status;
	private $card;
	private $difficulty;

	public function __construct($dbCommunicator) {
		$this->dbComm = $dbCommunicator;
		$this->status = "";
		
		// check to see if there's a card that needs to be scheduled; if so, schedule it
		$this->scheduleCardIfPossible();
	}
	
	// this method checks to make sure there is a card, and if there is, schedule it
	private function scheduleCardIfPossible() {
		// check for card and difficulty
		$this->checkForCard();
		
		// if we have a card and a difficulty, schedule it
		if (isset($this->card) && isset($this->difficulty)) {
			$this->scheduleCard();
			
			// now that the card is properly scheduled, insert it back into database
			$this->dbComm->appendCard($this->card);
			
			// set the status string
			if ($this->card->interval == 1)
				$this->status = "Previous card will be seen again in " . $this->card->interval . " day.";
			else
				$this->status = "Previous card will be seen again in " . $this->card->interval . " days.";
		}
	}
	
	// schedules a card; expects card and difficulty to be set
	private function scheduleCard() {
		global $DIFFICULTY_POST_WRONG, $DIFFICULTY_POST_HARD,
				$DIFFICULTY_POST_GOOD, $DIFFICULTY_POST_EASY;
				
		$currentInterval = $this->card->interval;
		$newInterval = 0;
		
		if ($currentInterval == 0) {
			if ($this->difficulty == $DIFFICULTY_POST_WRONG)
				$newInterval = 0;
			elseif ($this->difficulty == $DIFFICULTY_POST_HARD)
				$newInterval = 1;
			elseif ($this->difficulty == $DIFFICULTY_POST_GOOD)
				$newInterval = 2;
			else
				$newInterval = 3;
		} else {
			// note: the interval spacings as they are are fake numbers and not actually 
			//	based on real science
			if ($this->difficulty == $DIFFICULTY_POST_WRONG)
				$newInterval = 0;
			elseif ($this->difficulty == $DIFFICULTY_POST_HARD)
				$newInterval = (int)($currentInterval * 1.5);
			elseif ($this->difficulty == $DIFFICULTY_POST_GOOD)
				$newInterval = (int)($currentInterval * 2.5);
			else
				$newInterval = (int)($currentInterval * 4);
		}
		
		$this->card->interval = $newInterval;
		$this->card->lastSeenDate = date("Y-m-d");
		$this->card->nextDate = date("Y-m-d", strtotime("+" . $newInterval . " days"));
	}
	
	// this method checks for a card and a difficulty to schedule with and sets the class
	//	properties if they're there
	private function checkForCard() {
		global $DIFFICULTY_POST_VARIABLE, $CARD_ID_VARIABLE;
				
		if (isset($_POST[$CARD_ID_VARIABLE])) {
			$cardID = (int)$_POST[$CARD_ID_VARIABLE];
			$this->card = $this->dbComm->getCardWithID($cardID);
		}
		
		if (isset($this->card)) {
			if (isset($_POST[$DIFFICULTY_POST_VARIABLE]))
				$this->difficulty = $_POST[$DIFFICULTY_POST_VARIABLE];
		}
	}
	
	public function statusString() {
		return $this->status;
	}
}
 
?>