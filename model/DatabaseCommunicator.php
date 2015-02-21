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

// Database Information; change as needed
$DB_NAME = "flashcards";
$DB_USERNAME = "flashcards";
$DB_PASSWORD = "jYRALpMbvGqbpCAL";
$DB_URL = "localhost";
$DB_PORT = 3306;

// constants (table names)
$CARD_TABLE_NAME = "flashcards";

class DatabaseCommunicator {
	private $db;

	public function __construct() {
		global $DB_NAME, $DB_USERNAME, $DB_PASSWORD, $DB_PORT, $DB_URL;
	
		// connect to mysql and select the correct db
		$this->db = new PDO('mysql:host=' . $DB_URL . ';port=' . $DB_PORT . ';dbname=' . 
			$DB_NAME . ';charset=utf8', $DB_USERNAME, $DB_PASSWORD);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		// check if card table exists; if not create it
		if (!$this->cardTableExists())
			$this->createCardTable();
	}
	
	// checks if the flashcard table exists
	private function cardTableExists() {
		global $CARD_TABLE_NAME;
		$CARD_TABLE_NOT_EXIST_ERROR_CODE = "42S02";
			
		try {
			// if this comes back error-free, return true
			$this->db->query('SELECT 1 FROM ' . $CARD_TABLE_NAME . ' LIMIT 1');
		} catch(PDOException $ex) {
			if ($ex->getCode() == $CARD_TABLE_NOT_EXIST_ERROR_CODE)
				return false;
			else
				echo $ex;
		}
		
		return true;
	}
	
	// creates the flashcard table
	private function createCardTable() {
		global $CARD_TABLE_NAME;
	
		$this->db->query('CREATE TABLE ' . $CARD_TABLE_NAME . ' (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			front VARCHAR(16000000) NOT NULL,
			back VARCHAR(16000000),
			lastSeen DATE,
			nextShow DATE,
			cardInterval INT(6) UNSIGNED
		)');
	}
	
	// gets the card that needs to be reviewed
	public function getReviewCard() {
		// TODO
	}
	
	// gets all cards in range (0 is newest, n-1 is oldest) in an array
	//	$firstCard must be less than or equal to $lastCard
	//	$lastCard must be less than countCards()
	public function getCards($firstCard, $lastCard) {
		if ($firstCard > $lastCard)
			exit("DatabaseCommunicator error: $firstCard greater than $lastCard");
		if ($lastCard >= $this->countCards())
			exit("DatabaseCommunicator error: $lastCard greater than or equal to countCards()");
		
		// TODO
	}
	
	// gets total number of cards in database
	public function countCards() {
		// TODO
	}
	
	// adds a card to the database
	//	$card must be of type Card
	public function addCard($card) {
		// TODO
	}
	
	// deletes a card from the database
	//	$card must be of type Card
	//	does nothing if card does not exist in database
	public function deleteCard($card) {
		// TODO
	}
	
	// appends a card in the database
	//	$card must be of type Card
	//	does nothing if card does not exist in database
	public function appendCard($card) {
		// TODO
	}
}

// test shit
$dbcomm = new DatabaseCommunicator();

?>