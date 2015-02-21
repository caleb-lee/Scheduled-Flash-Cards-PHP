<?php
/***
 * MainMenuView class
 * Author: Caleb Lee
 *
 * This class simply displays a menu to go to various portions of the web app.
 ***/
require_once(__DIR__ . '/../constants.php');
require_once('GenericView.php');

class MainMenuView extends GenericView {
	public function __construct() {
		$this->title = "Scheduled Flash Cards";
		$this->body = $this->generateBody();
	}
	
	private function generateBody() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_ADD, $PAGE_GET_NAME_REVIEW;
		
		$body = "<a href=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_ADD . 
					"\">Add Cards</a><br /><br />";
		$body = $body . "<a href=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_REVIEW . 
					"\">Review Cards</a>";
		
		return $body;
	}
}

?>