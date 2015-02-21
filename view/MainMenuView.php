<?php
/***
 * MainMenuView class
 * Author: Caleb Lee
 *
 * This class simply displays a menu to go to various portions of the web app.
 ***/
require_once(__DIR__ . '/../constants.php');

class MainMenuView {
	public function output() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_ADD, $PAGE_GET_NAME_REVIEW;
	
		$output = "<h2>Scheduled Flash Cards</h2>";
		$output = $output . "<a href=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_ADD . "\">Add Cards</a><br /><br />";
		$output = $output . "<a href=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_REVIEW . "\">Review Cards</a>";
		
		return $output;
	}
}

?>