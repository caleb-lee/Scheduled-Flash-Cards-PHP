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
require_once(__DIR__ . '/../controller/AddController.php');
 
class AddView extends GenericView {
	private $controller;
	
	const TEXT_AREA_ROWS = 15;
	const TEXT_AREA_COLS = 70;

	public function __construct($controller) {
		$this->title = "Add Card";
		$this->body = ""; // we are going to generate the body when body is called
		$this->controller = $controller;
	}
	
	private function generateBody() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_ADD, $ADD_POST_VARIABLE_FRONT, 
					$ADD_POST_VARIABLE_BACK;
		
		$body = "";
		
		if ($this->controller->statusString() != "")
			$body = $body . "<p>" . $this->controller->statusString() . "</p>";
		
		$body = $body . "<form action=\"?" . $PAGE_GET_VAR . "=" . 
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
		
		
		return "<textarea name=\"" . $name . "\" rows=\"" . self::TEXT_AREA_ROWS . 
					"\" cols=\"" . self::TEXT_AREA_COLS . "\"></textarea><br /><br />";
	}
	
	public function output() {
		$this->body = $this->generateBody();
	
		return parent::output();
	}
}
?>