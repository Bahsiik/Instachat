<?php
declare(strict_types=1);

namespace Models;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use PDO;

class Reaction {
	public string $emoji;
	public float $id;
	public float $postId;
}

class ReactionsRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function addReaction(float $post_id, string $emoji, float $user_id): bool {
		$statement = $this->databaseConnection->prepare(<<<SQL
			INSERT INTO reactions (post_id, emoji)
			VALUES (:post_id, :emoji)
			ON DUPLICATE KEY UPDATE id = id;
			
			INSERT INTO reaction_users (reaction_id, user_id)
			SELECT id, :user_id AS user_id
			FROM reactions
			WHERE post_id = :post_id AND emoji = :emoji;
		SQL
		);
		return $statement->execute(compact('post_id', 'emoji', 'user_id'));
	}

	public function deleteReaction(float $post_id, float $user_id, string $emoji): void {
		$statement = $this->databaseConnection->prepare(<<<SQL
			DELETE reaction_users
			FROM reaction_users
			JOIN reactions ON reactions.id = reaction_users.reaction_id
			WHERE reactions.post_id = :post_id AND reactions.emoji = :emoji AND reaction_users.user_id = :user_id;
		SQL
		);
		$statement->execute(compact('post_id', 'emoji', 'user_id'));
	}

	/**
	 * @param float $post_id
	 * @return Array<Reaction>
	 */
	public function getReactionsByPostId(float $post_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM reactions WHERE post_id = :post_id');
		$statement->execute(compact('post_id'));
		return $statement->fetchAll(PDO::FETCH_CLASS, Reaction::class);
	}
}
