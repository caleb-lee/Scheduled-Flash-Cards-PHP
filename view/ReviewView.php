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
			$body = $body . "<p>" . $this->getCardBack() . "</p>";
			
			// display difficulty buttons
			$body = $body . $this->getDifficultyButtons();
			
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
		// use hidden forms to communicate card id and answer mode
		$answerButton = $this->getAnswerFormHeader() . "<input type=\"hidden\" name=\"" 
						. self::CARD_MODE_VARIABLE . "\" value=\"" . 
						self::CARD_MODE_ANSWER . "\">" . $this->makeCardIDInput() . "
						<input type=\"submit\" value=\"Show Back\"></form>";
	
		return $answerButton;
	}
	
	private function getCardBack() {
		if (isset($_POST[self::CARD_ID_VARIABLE])) {
			$cardID = (int)($_POST[self::CARD_ID_VARIABLE]);
			
			$this->card = $this->dbComm->getCardWithID($cardID);
			return $this->card->back;
		} else
			exit("ReviewView getCardBack() called unexpectedly");
	}
	
	private function getDifficultyButtons() {
		global $DIFFICULTY_POST_VARIABLE, $DIFFICULTY_POST_WRONG, $DIFFICULTY_POST_HARD,
				$DIFFICULTY_POST_GOOD, $DIFFICULTY_POST_EASY;

		$buttons = $this->getAnswerFormHeader();
		
		// make a hidden table to lay out the buttons
		$buttons = $buttons . '<table border="0px"><tr>';
		
		// make buttons within the table
		$buttons = $buttons . "<td>" . $this->makeSubmitButtonWithNameAndValue($DIFFICULTY_POST_VARIABLE, $DIFFICULTY_POST_WRONG) . "</td>";
		$buttons = $buttons . "<td>" . $this->makeSubmitButtonWithNameAndValue($DIFFICULTY_POST_VARIABLE, $DIFFICULTY_POST_HARD) . "</td>";
		$buttons = $buttons . "<td>" . $this->makeSubmitButtonWithNameAndValue($DIFFICULTY_POST_VARIABLE, $DIFFICULTY_POST_GOOD) . "</td>";
		$buttons = $buttons . "<td>" . $this->makeSubmitButtonWithNameAndValue($DIFFICULTY_POST_VARIABLE, $DIFFICULTY_POST_EASY) . "</td>";
		
		// end the table
		$buttons = $buttons . "</tr></table>";
		
		// make hidden forms to communicate card ID and question mode
		$buttons = $buttons . "<input type=\"hidden\" name=\""
					 . self::CARD_MODE_VARIABLE . "\" value=\"" . 
					 self::CARD_MODE_QUESTION . "\">";
		$buttons = $buttons . $this->makeCardIDInput();
		
		// end the form
		$buttons = $buttons . "</form>";
		
		return $buttons;
	}
	
	private function makeCardIDInput() {
		return "<input type=\"hidden\" name=\"" . self::CARD_ID_VARIABLE . "\" value=\"" . 
					$this->card->cardID . "\">";
	}
	
	private function makeSubmitButtonWithNameAndValue($name, $value) {
		return "<input type=\"submit\" name=\"" . $name . "\" value=\"" . $value . "\">";
	}
	
	private function getAnswerFormHeader() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_REVIEW;
		
		return "<form action=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_REVIEW . 
						"\" method=\"POST\">";
	}
	
	public function output() {
		$this->body = $this->generateBody();
		
		return parent::output();
	}
}

?>