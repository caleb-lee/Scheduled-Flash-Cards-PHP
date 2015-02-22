<?php
/***
 * AddController class
 * Author: Caleb Lee
 *
 * This class will control adding cards to the database whenever needed.
 ***/
 
require_once(__DIR__ . '/../constants.php');
require_once(__DIR__ . '/../model/DatabaseCommunicator.php');
require_once(__DIR__ . '/../model/Card.php');

class AddController {
	private $dbCommunicator;
	private $cardAdded;
	private $statusString;
	
	public function __construct($dbCommunicator) {
		$this->dbCommunicator = $dbCommunicator;
		$this->cardAdded = false;
		$this->statusString = "";
		
		$this->addCardFromPost();
	}
	
	private function addCardFromPost() {
		global $ADD_POST_VARIABLE_FRONT, $ADD_POST_VARIABLE_BACK;
		
		$front;
		$back;
		
		if (isset($_POST[$ADD_POST_VARIABLE_FRONT])) {
			$front = $_POST[$ADD_POST_VARIABLE_FRONT];
			
			if (isset($_POST[$ADD_POST_VARIABLE_BACK]))
				$back = $_POST[$ADD_POST_VARIABLE_BACK];
			else
				$back = "";
		}
		
		if (!empty($front)) {
			$newCard = new Card($front, $back);
			$this->dbCommunicator->addCard($newCard);
			$this->cardAdded = true;
			$this->statusString = "Card added successfully.";
		} else {
			$this->statusString = "Card not added successfully. Missing front.";
		}
	}
	
	public function cardAdded() {
		return $this->cardAdded;
	}
	
	public function statusString() {
		return $this->statusString;
	}
}

?>