<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;

class Friend
{
    public DateTime $send_date;
    public DateTime $accept_date;

    public function __construct(
        public float $requester_id,
        public float $requested_id,
        public bool  $accepted,
        string       $send_date,
        string       $accept_date
    )
    {
        $this->send_date = date_create_from_format('U', $send_date);
        $this->accept_date = date_create_from_format('U', $accept_date);
    }
}

class FriendRepository
{
    public PDO $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = DatabaseConnection::getConnection();
    }

    public function sendRequest(float $requester_id, float $requested_id): void
    {
        $statement = $this->databaseConnection->prepare('INSERT INTO friends (requester_id, requested_id) VALUES (:requester_id, :requested_id)');
	    $statement->execute(compact('requester_id', 'requested_id'));
    }

    public function acceptRequest(float $requester_id, float $requested_id): void
    {
        $statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = true, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
        $statement->execute([
            'requester_id' => $requester_id,
            'requested_id' => $requested_id,
            'response_date' => time(),
        ]);
    }

    public function rejectRequest(float $requester_id, float $requested_id): void
    {
        $statement = $this->databaseConnection->prepare('UPDATE friends SET accepted = false, response_date = :response_date WHERE requester_id = :requester_id AND requested_id = :requested_id');
        $statement->execute([
            'requester_id' => $requester_id,
            'requested_id' => $requested_id,
            'response_date' => time(),
        ]);
    }
}
