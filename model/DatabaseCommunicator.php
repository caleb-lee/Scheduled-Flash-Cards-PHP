<?php
/**
 * Card class
 * Author: Caleb Lee
 *
 * This class does all database communication for the flash card application. It uses
 *	MySQL in its current form. It creates tables and entries in the given database 
 *	as needed.
 **/
 
require_once('Card.php');

$DB_NAME = "flashcards";
$DB_USERNAME = "flashcards";
$DB_PASSWORD = "jYRALpMbvGqbpCAL";
$DB_URL = "localhost";
$DB_PORT = 3306;

class DatabaseCommunicator {
	private $db;

	public function __construct() {
		global $DB_NAME, $DB_USERNAME, $DB_PASSWORD, $DB_PORT, $DB_URL;
	
		// connect to mysql and select the correct db
		$this->db = new PDO('mysql:host=' . $DB_URL . ';port=' . $DB_PORT . ';dbname=' . 
			$DB_NAME . ';charset=utf8', $DB_USERNAME, $DB_PASSWORD);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	
	// gets the card that needs to be reviewed
	public function getReviewCard() {
	
	}
	
	// gets all cards in range (0 is newest, n-1 is oldest)
	//	$firstCard must be less than or equal to $lastCard
	public function getCards($firstCard, $lastCard) {
		if ($firstCard > $lastCard)
			exit("DatabaseCommunicator error: $firstCard greater than $lastCard");
	
	}
	
	// gets total number of cards in database
	public function countCards() {
	
	}
	
	// adds a card to the database
	//	$card must be of type Card
	public function addCard($card) {
	
	}
	
	// deletes a card from the database
	//	$card must be of type Card
	//	does nothing if card does not exist in database
	public function deleteCard($card) {
	
	}
}

// test shit
$dbcomm = new DatabaseCommunicator();

?>