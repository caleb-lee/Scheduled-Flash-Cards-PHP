<?php
/**
 * Card class
 * Author: Caleb Lee
 *
 * This class does all database communication and converts everything into usable forms
 *	(i.e., Card objects) for the rest of the application. In its current form, it uses
 *	MySQL.
 **/
 
require_once('Card.php');

class DatabaseCommunicator {
	// Database Information; change as needed
	const DB_NAME = "flashcards";
	const DB_USERNAME = "flashcards";
	const DB_PASSWORD = "jYRALpMbvGqbpCAL";
	const DB_URL = "localhost";
	const DB_PORT = 3306;
	
	// constants (table/column names)
	const CARD_TABLE_NAME = "flashcards";
	const CARD_ENTRY_ID = "id";
	const CARD_ENTRY_FRONT = "front";
	const CARD_ENTRY_BACK = "back";
	const CARD_ENTRY_LAST_SEEN = "lastSeen";
	const CARD_ENTRY_NEXT_SHOW = "nextShow";
	const CARD_ENTRY_INTERVAL = "cardInterval";
	
	private $db;

	public function __construct() {
		// connect to mysql and select the correct db
		$this->db = new PDO('mysql:host=' . self::DB_URL . ';port=' . self::DB_PORT . 
							';dbname=' . self::DB_NAME . ';charset=utf8', 
							self::DB_USERNAME, self::DB_PASSWORD);
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
			' . self::CARD_ENTRY_ID . ' INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			' . self::CARD_ENTRY_FRONT . ' VARCHAR(16000000) NOT NULL,
			' . self::CARD_ENTRY_BACK . ' VARCHAR(16000000),
			' . self::CARD_ENTRY_LAST_SEEN . ' DATE,
			' . self::CARD_ENTRY_NEXT_SHOW . ' DATE,
			' . self::CARD_ENTRY_INTERVAL . ' INT(6) UNSIGNED
		)');
	}
	
	// get card with ID
	public function getCardWithID($cardID) {
		// do sql query
		$result = $this->db->query('SELECT * FROM ' . self::CARD_TABLE_NAME . '
									WHERE id=' . $cardID);
		$row = $result->fetch();
		if (!empty($row)) {
			$resultCard = $this->makeCardFromFetchedRow($row);
		
			return $resultCard;
		}
	}
	
	private function makeCardFromFetchedRow($row) {
		$resultCard = new Card($row[self::CARD_ENTRY_FRONT], $row[self::CARD_ENTRY_BACK]);
		
		$resultCard->cardID = $row[self::CARD_ENTRY_ID];
		$resultCard->lastSeenDate = $row[self::CARD_ENTRY_LAST_SEEN];
		$resultCard->nextDate = $row[self::CARD_ENTRY_NEXT_SHOW];
		$resultCard->interval = $row[self::CARD_ENTRY_INTERVAL];
		
		return $resultCard;
	}
	
	// gets the card that needs to be reviewed
	//	this grabs a single card which has a due date less than or equal to today
	//	if there are no due cards; it returns null
	public function getReviewCard() {
		$result = $this->db->query('SELECT * FROM ' . self::CARD_TABLE_NAME . '
									WHERE ' . self::CARD_ENTRY_NEXT_SHOW . ' <= CURDATE()
									ORDER BY ' . self::CARD_ENTRY_NEXT_SHOW . ', ' 
									. self::CARD_ENTRY_LAST_SEEN . ' ASC LIMIT 1');
		$row = $result->fetch();
		
		if (!empty($row)) {
			$resultCard = $this->makeCardFromFetchedRow($row);
			return $resultCard;
		}
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
		
		$limit = ($lastCard - $firstCard) + 1;
		$result = $this->db->query('SELECT * FROM ' . self::CARD_TABLE_NAME . '
									ORDER BY ' . self::CARD_ENTRY_NEXT_SHOW . ' ASC 
									LIMIT ' . $limit . ' OFFSET ' . $firstCard);
									
		$cardArray;
		$i = 0;
		$row = $result->fetch();
		while (!empty($row)) {
			$cardArray[$i] = $this->makeCardFromFetchedRow($row);
			$i++;
			$row = $result->fetch();
		}
		
		return $cardArray;
	}
	
	// gets total number of cards in database
	public function countCards() {
		$countResult = $this->db->query('SELECT * FROM ' . self::CARD_TABLE_NAME);
		return $countResult->rowCount();
	}
	
	// adds a card to the database
	//	$card must be of type Card
	public function addCard($card) {
		// prepare SQL statement
		$stmt = $this->db->prepare('INSERT INTO ' . self::CARD_TABLE_NAME . 
											'(' . self::CARD_ENTRY_FRONT . ',
											' . self::CARD_ENTRY_BACK . ',
											' . self::CARD_ENTRY_LAST_SEEN . ',
											' . self::CARD_ENTRY_NEXT_SHOW . ',
											' . self::CARD_ENTRY_INTERVAL . ')
									VALUES ( \'' . $card->front . '\',
											 \'' . $card->back . '\',
											 \'' . $card->lastSeenDate . '\',
											 \'' . $card->nextDate . '\',
											 \'' . $card->interval . '\');');
		
		// execute statement and edit card object to have correct ID
		if ($stmt->execute())
			$card->cardID = $this->db->lastInsertId();
	}
	
	// deletes a card from the database
	//	$card must be of type Card
	//	does nothing if card with id doesn't exist in database
	//	ONLY THE ID HAS TO MATCH
	public function deleteCard($card) {
		// prepare SQL statement
		$stmt = $this->db->prepare('DELETE FROM ' . self::CARD_TABLE_NAME . ' WHERE
									id=' . $card->cardID . ' LIMIT 1');
									
		// execute statement
		$stmt->execute();
	}
	
	// appends a card in the database
	//	$card must be of type Card
	//	does nothing if card with id does not exist in database
	//	ONLY THE ID HAS TO MATCH
	public function appendCard($card) {
		// prepare SQL statement
		$stmt = $this->db->prepare('UPDATE ' . self::CARD_TABLE_NAME . '
									SET ' . self::CARD_ENTRY_FRONT . '=\'' . $card->front . '\',
										' . self::CARD_ENTRY_BACK . '=\'' . $card->back . '\',
										' . self::CARD_ENTRY_LAST_SEEN . '=\'' . $card->lastSeenDate . '\',
										' . self::CARD_ENTRY_NEXT_SHOW . '=\'' . $card->nextDate . '\',
										' . self::CARD_ENTRY_INTERVAL . '=\'' . $card->interval . '\'
									WHERE id=' . $card->cardID . '');
		
		// execute statement
		$stmt->execute();
	}
}

?>