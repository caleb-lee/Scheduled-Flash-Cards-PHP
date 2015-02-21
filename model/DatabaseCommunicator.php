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

class DatabaseCommunicator {
	// Database Information; change as needed
	const DB_NAME = "flashcards";
	const DB_USERNAME = "flashcards";
	const DB_PASSWORD = "jYRALpMbvGqbpCAL";
	const DB_URL = "localhost";
	const DB_PORT = 3306;
	
	// constants (table names)
	const CARD_TABLE_NAME = "flashcards";
	
	private $db;
	private $rowCount = -1;

	public function __construct() {
		// connect to mysql and select the correct db
		$this->db = new PDO('mysql:host=' . self::DB_URL . ';port=' . self::DB_PORT . ';dbname=' . 
			self::DB_NAME . ';charset=utf8', self::DB_USERNAME, self::DB_PASSWORD);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		// check if card table exists; if not create it
		if (!$this->cardTableExists())
			$this->createCardTable();
	}
	
	// checks if the flashcard table exists
	private function cardTableExists() {
		$CARD_TABLE_NOT_EXIST_ERROR_CODE = "42S02";
		
		// try to select something from the table
		//	if it errors with the correct code (i.e., that the table doesn't exist),
		//	return false. if it doesn't error, return true. if there's a different error,
		//	display it.
		try {
			// if this comes back error-free, return true
			$this->db->query('SELECT 1 FROM ' . self::CARD_TABLE_NAME . ' LIMIT 1');
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
		$this->db->query('CREATE TABLE ' . self::CARD_TABLE_NAME . ' (
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
	// $firstCard must be >= 0
	public function getCards($firstCard, $lastCard) {
		if ($firstCard > $lastCard)
			exit("DatabaseCommunicator error: $firstCard greater than $lastCard");
		if ($lastCard >= $this->countCards())
			exit("DatabaseCommunicator error: $lastCard greater than or equal to countCards()");
		if ($firstCard < 0)
			exit("DatabaseCommunicator error: $firstCard less than 0");
		
		// TODO
	}
	
	// gets total number of cards in database
	public function countCards() {
		// keep track of rowCount so we don't have to query every time we need it
		if ($this->rowCount == -1) {
			$countResult = $this->db->query('SELECT * FROM ' . self::CARD_TABLE_NAME);
			$this->rowCount = $countResult->rowCount();
		}
	
		return $this->rowCount;
	}
	
	// adds a card to the database
	//	$card must be of type Card
	public function addCard($card) {
		// TODO
		
		
	}
	
	// deletes a card from the database
	//	$card must be of type Card
	//	does nothing if card with id doesn't exist in database
	public function deleteCard($card) {
		// TODO
	}
	
	// appends a card in the database
	//	$card must be of type Card
	//	does nothing if card with id does not exist in database
	public function appendCard($card) {
		// TODO
	}
}

// test shit
$dbcomm = new DatabaseCommunicator();
echo $dbcomm->countCards();

?>