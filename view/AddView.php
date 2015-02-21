<?php
/***
 * AddView class
 * Author: Caleb Lee
 *
 * This class represents a prompt to add a card to the program.
 * Use the "output" method to obtain the full view.
 ***/
 
require_once(__DIR__ . '/../constants.php');
 
class AddView {
	public function output() {
		global $PAGE_GET_VAR, $PAGE_GET_NAME_ADD, $ADD_POST_VARIABLE_FRONT, $ADD_POST_VARIABLE_BACK;
	
		$output = "<h2>Add Card</h2>";
		
		// add the form
		$output = $output . "<form action=\"?" . $PAGE_GET_VAR . "=" . $PAGE_GET_NAME_ADD . "\" method=\"post\">\n";
		$output = $output . "Card Front: <br />\n";
		$output = $output . "<textarea name=\"" . $ADD_POST_VARIABLE_FRONT . "\"></textarea><br /><br />\n";
		$output = $output . "Card Back: <br />\n";
		$output = $output . "<textarea name=\"" . $ADD_POST_VARIABLE_BACK . "\"></textarea><br /><br />\n";
		$output = $output . "<input type=\"submit\" value=\"Submit\">";
		$output = $output . "</form>\n";
		
		return $output;
	}
}
?>