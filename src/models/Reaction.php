<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use PDO;

class Reaction {

	/**
	 * @var Array<float>
	 */
	public array $users;

	public function __construct(public float $id, public float $postId, public string $emoji, ?string $users) {
		$this->users = isset($users) ? array_map(static fn($u) => (float)$u, explode(',', $users)) : [];
	}

	public function getCount(): int {
		return count($this->users);
	}

	public function hasReacted(float $user_id): bool {
		return in_array($user_id, $this->users, true);
	}
}

class ReactionsRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function addUserReaction(float $reaction_id, float $user_id) {
		$statement = $this->databaseConnection->prepare(<<<SQL
			INSERT INTO reaction_users (reaction_id, user_id)
			VALUES (:reaction_id, :user_id);
		SQL
		);
		return $statement->execute(compact('reaction_id', 'user_id'));
	}

	public function createReaction(float $post_id, string $emoji, float $user_id): bool {
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

	public function removeUserReaction(float $reaction_id, float $user_id) {
		$statement = $this->databaseConnection->prepare(<<<SQL
			DELETE FROM reaction_users
			WHERE reaction_id = :reaction_id AND user_id = :user_id;
			DELETE FROM reactions
			WHERE id = :reaction_id AND NOT EXISTS (SELECT * FROM reaction_users WHERE reaction_id = :reaction_id);
		SQL
		);
		return $statement->execute(compact('reaction_id', 'user_id'));
	}

	/**
	 * @param float $post_id
	 * @return Array<Reaction>
	 */
	public function getReactionsByPostId(float $post_id): array {
		$statement = $this->databaseConnection->prepare('SELECT reactions.*, GROUP_CONCAT(reaction_users.user_id) AS users
			FROM reactions
			LEFT JOIN reaction_users ON reactions.id = reaction_users.reaction_id
			WHERE reactions.post_id = :post_id
			GROUP BY reactions.id;
		');
		$statement->execute(compact('post_id'));
		$reactions = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array_map(static fn($reaction) => new Reaction(...array_values($reaction)), $reactions);
	}

	/**
	 * @param float $author_id
	 * @return Array<Reaction>
	 */
	public function getReactionsByAuthorId(float $author_id): array {
		$author = (string)$author_id;
		$statement = $this->databaseConnection->prepare("SELECT reactions.*, '$author' FROM reactions WHERE id IN (SELECT reaction_id FROM reaction_users WHERE user_id = :author_id)");
		$statement->execute(compact('author_id'));
		$reactions = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array_map(static fn($reaction) => new Reaction(...array_values($reaction)), $reactions);
	}
}
