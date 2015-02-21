<?php
/***
 * ErrorView class
 * Author: Caleb Lee
 *
 * This class represents an error page, only accessed when the user goes to a page=
 *	that does not exist.
 ***/
require_once('GenericView.php');
 
class ErrorView extends GenericView {
	public function __construct() {
		$this->title = "Error";
		$this->body = "<p>Page does not exist</p>";
	}
}

?>