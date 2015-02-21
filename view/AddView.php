<?php
/***
 * AddView class
 * Author: Caleb Lee
 *
 * This class represents a prompt to add a card to the program.
 * Use the "body" method to obtain the full view.
 ***/
 
require_once(__DIR__ . '/../constants.php');
require_once('GenericView.php');
 
class AddView extends GenericView {
	public function __construct() {
		$this->title = "Add Card";
		$this->body = ""; // we are going to generate the body when body is called
	}
	
	private function generateBody() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_ADD, $ADD_POST_VARIABLE_FRONT, 
					$ADD_POST_VARIABLE_BACK;
		
		$body = "<form action=\"?" . $PAGE_GET_VAR . "=" . 
					$PAGE_GET_NAME_ADD . "\" method=\"post\">\n";
		$body = $body . "Card Front: <br />\n";
		$body = $body . $this->generateTextAreaWithName($ADD_POST_VARIABLE_FRONT);
		$body = $body . "Card Back: <br />\n";
		$body = $body . $this->generateTextAreaWithName($ADD_POST_VARIABLE_BACK);
		$body = $body . "<input type=\"submit\" value=\"Submit\">";
		$body = $body . "</form>\n";
		
		return $body;
	}
	
	private function generateTextAreaWithName($name) {
		$TEXT_AREA_ROWS = 15;
		$TEXT_AREA_COLS = 70;
		
		return "<textarea name=\"" . $name . "\" rows=\"" . $TEXT_AREA_ROWS . 
					"\" cols=\"" . $TEXT_AREA_COLS . "\"></textarea><br /><br />";
	}
	
	public function output() {
		$this->body = $this->generateBody();
	
		return parent::output();
	}
}
?>