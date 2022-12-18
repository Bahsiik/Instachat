<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use DateTime;
use PDO;

/**
 * Class Blocked is a class that represents a blocked user
 * @package Models
 */
class Blocked {
	public DateTime $blockedDate;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct(
		public float   $blockerId,
		public ?float  $blockedId,
		public ?string $blockedWord,
		string         $blockedDate,
	) {
		$this->blockedDate = date_create_from_format('Y-m-d H:i:s', $blockedDate);
	}
}

/**
 * Class BlockedRepository is a class that represents a blocked user repository
 * @package Models
 */
class BlockedRepository {
	public PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * blockUser is the function that blocks a user
	 * @param float $blocker_id - the id of the user that blocks the other user
	 * @param float $blocked_id - the id of the user that is blocked
	 * @return void
	 */
	public function blockUser(float $blocker_id, float $blocked_id): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_id) VALUES (:blocker_id, :blocked_id)');
		$statement->execute(compact('blocker_id', 'blocked_id'));
	}

	/**
	 * blockWord is the function that blocks a word
	 * @param float $blocker_id - the id of the user that blocks the word
	 * @param string $blocked_word - the word that is blocked
	 * @return void
	 */
	public function blockWord(float $blocker_id, string $blocked_word): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_word) VALUES (:blocker_id, :blocked_word)');
		$statement->execute(compact('blocker_id', 'blocked_word'));
	}

	/**
	 * unblockUser is the function that unblocks a user
	 * @param float $blocker_id - the id of the user that blocks the other user
	 * @param float $blocked_id - the id of the user that is blocked
	 * @return void
	 */
	public function unblockUser(float $blocker_id, float $blocked_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_id = :blocked_id');
		$statement->execute(compact('blocker_id', 'blocked_id'));
	}

	/**
	 * unblockWord is the function that unblocks a word
	 * @param float $blocker_id - the id of the user that blocks the word
	 * @param string $blocked_word - the word that is blocked
	 * @return void
	 */
	public function unblockWord(float $blocker_id, string $blocked_word): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_word = :blocked_word');
		$statement->execute(compact('blocker_id', 'blocked_word'));
	}

	/**
	 * getBlockedUsers is the function that gets the blocked users of a user
	 * @param float $blocker_id - the id of the user that blocks the other users
	 * @return Array<Blocked> - the blocked users
	 */
	public function getBlockedUsers(float $blocker_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_id IS NOT NULL');
		$statement->execute(compact('blocker_id'));
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$blocked[] = new Blocked(
				$row['blocker_id'],
				$row['blocked_id'],
				$row['blocked_word'],
				$row['blocked_date'],
			);
		}
		return $blocked ?? [];
	}


	/**
	 * getBlockers is the function that gets the users that block a user
	 * @param float $blocked_id - the id of the user that is blocked
	 * @return array - the users that block the user
	 */
	public function getBlockers(float $blocked_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocked_id = :blocked_id AND blocked_id IS NOT NULL');
		$statement->execute(compact('blocked_id'));
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$blocked[] = new Blocked(
				$row['blocker_id'],
				$row['blocked_id'],
				$row['blocked_word'],
				$row['blocked_date'],
			);
		}
		return $blocked ?? [];
	}

	/**
	 * getBlockedWords is the function that gets the blocked words of a user
	 * @param float $blocker_id - the id of the user that blocks the words
	 * @return Array<Blocked> - the blocked words
	 */
	public function getBlockedWords(float $blocker_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_word IS NOT NULL');
		$statement->execute(compact('blocker_id'));
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$blocked[] = new Blocked(
				$row['blocker_id'],
				$row['blocked_id'],
				$row['blocked_word'],
				$row['blocked_date'],
			);
		}
		return $blocked ?? [];
	}

	/**
	 * isBlocked is the function that checks if a user is blocked
	 * @param float $blocker_id - the id of the user that blocks the other user
	 * @param float $blocked_id - the id of the user that is blocked
	 * @return bool - true if the user is blocked, false otherwise
	 */
	public function isBlocked(float $blocker_id, float $blocked_id): bool {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_id = :blocked_id');
		$statement->execute(compact('blocker_id', 'blocked_id'));
		return $statement->rowCount() > 0;
	}

	/**
	 * getUsersThatBlocked is the function that gets the users that blocked a user
	 * @param float $user_id - the id of the user
	 * @return array - the users that blocked the user
	 */
	public function getUsersThatBlocked(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocked_id = :user_id AND blocked_id IS NOT NULL');
		$statement->execute(compact('user_id'));
		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$blocked[] = new Blocked(
				$row['blocker_id'],
				$row['blocked_id'],
				$row['blocked_word'],
				$row['blocked_date'],
			);
		}
		return $blocked ?? [];
	}
}
