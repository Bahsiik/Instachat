<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use DateTime;
use PDO;

/**
 * Class Friend represents a friend in the database.
 */
class Friend {
	public DateTime $sendDate;
	public DateTime $responseDate;
	public bool $accepted;

	/**
	 * __construct creates a new Friend.
	 * @param float $requesterId - The id of the requester.
	 * @param float $requestedId - The id of the requested.
	 * @param int $accepted - The status of the friend request.
	 * @param string $sendDate - The date when the friend request was sent.
	 * @param string $responseDate - The date when the friend request was responded.
	 */
	public function __construct(
		public float $requesterId,
		public float $requestedId,
		int          $accepted,
		string       $sendDate,
		string       $responseDate
	) {
		$this->sendDate = date_create_from_format('Y-m-d H:i:s', $sendDate);
		$this->responseDate = date_create_from_format('Y-m-d H:i:s', $responseDate);
		$this->accepted = $accepted === 1;
	}
}

/**
 * Class FriendRepository is used to interact with the friends in the database.
 */
class FriendRepository {
	public PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * sendRequest sends a friend request to the user with the given id.
	 * @param float $requester_id - The id of the requester.
	 * @param float $requested_id - The id of the requested.
	 * @return void - This function does not return anything.
	 */
	public function sendRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO friends (requester_id, requested_id) VALUES (:requester_id, :requested_id)');
		$statement->execute(compact('requester_id', 'requested_id'));
	}

	/**
	 * acceptRequest accepts a friend request.
	 * @param float $requester_id - The id of the requester.
	 * @param float $requested_id - The id of the requested.
	 * @return void - This function does not return anything.
	 */
	public function acceptRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = TRUE, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
		$statement->execute([
			'requester_id' => $requester_id,
			'requested_id' => $requested_id,
			'response_date' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * rejectRequest rejects a friend request.
	 * @param float $requester_id - The id of the requester.
	 * @param float $requested_id - The id of the requested.
	 * @return void - This function does not return anything.
	 */
	public function rejectRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = FALSE, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
		$statement->execute([
			'requester_id' => $requester_id,
			'requested_id' => $requested_id,
			'response_date' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * removeFriend removes a friend from the database.
	 * @param float $requester_id - The id of the requester.
	 * @param float $requested_id - The id of the requested.
	 * @return void - This function does not return anything.
	 */
	public function removeFriend(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM friends WHERE (requester_id = :requester_id AND requested_id = :requested_id) OR (requester_id = :requested_id AND requested_id = :requester_id)');
		$statement->execute(compact('requester_id', 'requested_id'));
	}

	/**
	 * cancelRequest cancels a friend request.
	 * @param float $requester_id - The id of the requester.
	 * @param float $requested_id - The id of the requested.
	 * @return void - This function does not return anything.
	 */
	public function cancelRequest(float $requester_id, float $requested_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM friends WHERE requester_id = :requester_id AND requested_id = :requested_id');
		$statement->execute(compact('requester_id', 'requested_id'));
	}

	/**
	 * getFriends gets all friends of the user with the given id.
	 * @param float $user_id - The id of the user.
	 * @return array - An array of friends.
	 */
	public function getFriends(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE (requester_id = :user_id OR requested_id = :user_id) AND accepted = TRUE');
		$statement->execute(compact('user_id'));
		$friends = [];

		while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
			$friends[] = new Friend(
				$friend['requester_id'],
				$friend['requested_id'],
				(int)$friend['accepted'],
				$friend['send_date'],
				$friend['response_date']
			);
		}

		return $friends;
	}

	/**
	 * getFriendRequests gets all friend requests of the user with the given id.
	 * @param float $user_id - The id of the user.
	 * @return array - An array of friend requests.
	 */
	public function getFriendRequests(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE requested_id = :user_id AND accepted IS NULL');
		$statement->execute(compact('user_id'));
		$friends = [];

		while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
			$friends[] = new Friend(
				$friend['requester_id'],
				$friend['requested_id'],
				(int)$friend['accepted'],
				$friend['send_date'],
				$friend['response_date']
			);
		}

		return $friends;
	}

	/**
	 * getSentRequests gets all sent friend requests of the user with the given id.
	 * @param float $user_id - The id of the user.
	 * @return array - An array of sent friend requests.
	 */
	public function getSentRequests(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM friends WHERE requester_id = :user_id AND accepted IS NULL');
		$statement->execute(compact('user_id'));
		$friends = [];

		while ($friend = $statement->fetch(PDO::FETCH_ASSOC)) {
			$friends[] = new Friend(
				$friend['requester_id'],
				$friend['requested_id'],
				(int)$friend['accepted'],
				$friend['send_date'],
				$friend['response_date']
			);
		}
		return $friends;
	}
}
