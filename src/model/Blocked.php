<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use PDO;

class Blocked
{
    public float $blocker_id;
    public float $blocked_id;
    public string $blocked_word;
}

class BlockedRepository
{
    public PDO $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = (new DatabaseConnection)->getConnection();
    }

    public function blockUser(float $blocker_id, float $blocked_id): void
    {
        $statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_id) VALUES (:blocker_id, :blocked_id)');
        $statement->execute(compact('blocker_id', 'blocked_id'));
    }

    public function blockWord(float $blocker_id, string $blocked_word): void
    {
        $statement = $this->databaseConnection->prepare('INSERT INTO blocked (blocker_id, blocked_word) VALUES (:blocker_id, :blocked_word)');
        $statement->execute(compact('blocker_id', 'blocked_word'));
    }

    public function unblockUser(float $blocker_id, float $blocked_id): void
    {
        $statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_id = :blocked_id');
        $statement->execute(compact('blocker_id', 'blocked_id'));
    }

    public function unblockWord(float $blocker_id, string $blocked_word): void
    {
        $statement = $this->databaseConnection->prepare('DELETE FROM blocked WHERE blocker_id = :blocker_id AND blocked_word = :blocked_word');
        $statement->execute(compact('blocker_id', 'blocked_word'));
    }

    public function getBlockedUsers(float $blocker_id): array
    {
        $statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_id IS NOT NULL');
        $statement->execute(compact('blocker_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Blocked::class);
    }

    public function getBlockedWords(float $blocker_id): array
    {
        $statement = $this->databaseConnection->prepare('SELECT * FROM blocked WHERE blocker_id = :blocker_id AND blocked_word IS NOT NULL');
        $statement->execute(compact('blocker_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Blocked::class);
    }
}