<?php
/***
 * ReviewView class
 * Author: Caleb Lee
 *
 * This class displays the card to be reviewed as well as an interface to rate the card.
 *	It may show the front or both the front and the back, depending on where the user is
 *	in the process.
 ***/

require_once('GenericView.php');
require_once(__DIR__ . '/../model/DatabaseCommunicator.php');
require_once(__DIR__ . '/../model/Card.php');

class ReviewView extends GenericView {
	private $dbComm;
	private $card;
	private $answerMode;
	
	const CARD_MODE_VARIABLE = "mode";
	const CARD_MODE_QUESTION = "question";
	const CARD_MODE_ANSWER = "answer";
	const CARD_ID_VARIABLE = "cardid";

	public function __construct($dbCommunicator) {
		$this->dbComm = $dbCommunicator;
		$this->title = "Review Cards";
		$this->body = ""; // generate it when shown
		$this->determineIfInAnswerMode();
	}
	
	// this function sets the answerMode property; basically it's checking to see if we
	//	should be displaying the question (+ the "show answer" button) or the answer (+
	//	rating buttons)
	private function determineIfInAnswerMode() {
		if (isset($_POST[self::CARD_MODE_VARIABLE]))
			$this->answerMode = ($_POST[self::CARD_MODE_VARIABLE] == self::CARD_MODE_ANSWER);
		else
			$this->answerMode = false;
	}
	
	private function generateBody() {
		$body = "";
	
		if ($this->answerMode) {
			// get card with ID
			// display back
			$body = $body + "<p>" . $this->getCardBack() . "</p>";
			
			// display difficulty buttons
			$body = $body + $this->getDifficultyButtons();
			
		} else {
			// get review card
			// display front
			$cardFront = $this->getCardFront();
			
			if ($cardFront == null) {
				$body = $body . "<p>No cards left to review.</p>";
			} else {
				$body = $body . "<p>" . $cardFront . "</p>";
				
				// display show answer button
				$body = $body . $this->getShowAnswerButton();
			}
		}
	
		return $body;
	}
	
	private function getCardFront() {
		$this->card = $this->dbComm->getReviewCard();
		
		if ($this->card != null)
			return $this->card->front;
		else
			return null;
	}
	
	private function getShowAnswerButton () {
		return ""; // TODO
	}
	
	private function getCardBack() {
		if (isset($_POST[self::CARD_ID_VARIABLE])) {
			$cardID = $_POST[self::CARD_ID_VARIABLE];
			
			$this->card = $this->dbComm->getCardWithID($cardID);
			return $this->card->back;
		} else
			return "";
	}
	
	private function getDifficultyButtons() {
		return "";  // TODO
	}
	
	public function output() {
		$this->body = $this->generateBody();
		
		return parent::output();
	}
}

?>