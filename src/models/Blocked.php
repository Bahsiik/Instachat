<?php
declare(strict_types=1);

namespace Models;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;

class Blocked {
	public DateTime $blockedDate;

	public function __construct(
		public float  $blockerId,
		public ?float  $blockedId,
		public ?string $blockedWord,
		string        $blockedDate,
	) {
		$this->blockedDate = date_create_from_format('Y-m-d H:i:s', $blockedDate);
	}
}

class BlockedRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function blockUser(float $blocker_id, float $blocked_id): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_id) VALUES (:blocker_id, :blocked_id)');
		$statement->execute(compact('blocker_id', 'blocked_id'));
	}

	public function blockWord(float $blocker_id, string $blocked_word): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_word) VALUES (:blocker_id, :blocked_word)');
		$statement->execute(compact('blocker_id', 'blocked_word'));
	}

	public function unblockUser(float $blocker_id, float $blocked_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_id = :blocked_id');
		$statement->execute(compact('blocker_id', 'blocked_id'));
	}

	public function unblockWord(float $blocker_id, string $blocked_word): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_word = :blocked_word');
		$statement->execute(compact('blocker_id', 'blocked_word'));
	}

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

	public function isBlocked(float $blocker_id, float $blocked_id): bool {
		$statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_id = :blocked_id');
		$statement->execute(compact('blocker_id', 'blocked_id'));
		return $statement->rowCount() > 0;
	}
}
