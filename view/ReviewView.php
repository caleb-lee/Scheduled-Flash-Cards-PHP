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

	public function __construct($dbCommunicator) {
		$this->dbComm = $dbCommunicator;
		$this->title = "Review Cards";
		$this->body = ""; // generate it when shown
	}
}

?>