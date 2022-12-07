<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;

class Friend {
	public DateTime $send_date;
	public DateTime $response_date;

	public function __construct(
		public float $requester_id,
		public float $requested_id,
		public bool  $accepted,
		string       $send_date,
		string       $response_date
	) {
		$this->send_date = date_create_from_format('Y-m-d H:i:s', $send_date);
		$this->response_date = date_create_from_format('Y-m-d H:i:s', $response_date);
	}
}

class FriendRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function sendRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO friends (requester_id, requested_id) VALUES (:requester_id, :requested_id)');
		$statement->execute(compact('requester_id', 'requested_id'));
	}

	public function acceptRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = true, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
		$statement->execute([
			'requester_id' => $requester_id,
			'requested_id' => $requested_id,
			'response_date' => time(),
		]);
	}

	public function rejectRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = false, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
		$statement->execute([
			'requester_id' => $requester_id,
			'requested_id' => $requested_id,
			'response_date' => time(),
		]);
	}

	public function removeFriend(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM friends WHERE (requester_id = :requester_id AND requested_id = :requested_id) OR (requester_id = :requested_id AND requested_id = :requester_id)');
		$statement->execute([
			'requester_id' => $requester_id,
			'requested_id' => $requested_id,
		]);
	}

	public function getFriends(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE (requester_id = :user_id OR requested_id = :user_id) AND accepted = true');
		$statement->execute(['user_id' => $user_id]);
		$friends = [];
		try {
			while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
				$friends[] = new Friend(
					$friend['requester_id'],
					$friend['requested_id'],
					$friend['accepted'] === 1,
					$friend['send_date'],
					$friend['response_date'],
				);
			}
		} catch (\Exception $e) {
			return [];
		}
		return $friends;
	}

	//request sent to the user
	function getFriendRequests(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE requested_id = :user_id AND accepted = false');
		$statement->execute(['user_id' => $user_id]);
		$friends = [];
		try {
			while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
				$friends[] = new Friend(
					$friend['requester_id'],
					$friend['requested_id'],
					$friend['accepted'] === 1,
					$friend['send_date'],
					$friend['response_date'],
				);
			}
		} catch (\Exception $e) {
			return [];
		}
		return $friends;
	}

	//request sent by the user
	function getSentRequests(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE requester_id = :user_id AND accepted = false');
		$statement->execute(['user_id' => $user_id]);
		$friends = [];
		try {
			while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
				$friends[] = new Friend(
					$friend['requester_id'],
					$friend['requested_id'],
					$friend['accepted'] === 1,
					$friend['send_date'],
					$friend['response_date'],
				);
			}
		} catch (\Exception $e) {
			return [];
		}
		return $friends;
	}
}
