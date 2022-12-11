<?php
declare(strict_types=1);

use Database\DatabaseConnection;

class Vote {
	public bool $isUpvote;

	public function __construct(
		public float $commentId,
		int          $type,
		public float $userId,
	) {
		$this->isUpvote = $type === 1;
	}
}

class VotesRepository {
	private PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * @param float $comment_id
	 * @return Array<Vote>
	 */
	public function getVotesByCommentId(float $comment_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM votes WHERE comment_id = :comment_id');
		$statement->execute(compact('comment_id'));
		$votes = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array_map(static fn($vote) => new Vote(...array_values($vote)), $votes);
	}

	public function getVoteByUserIdAndCommentId(float $comment_id, float $user_id): ?Vote {
		$statement = $this->databaseConnection->prepare('SELECT * FROM votes WHERE comment_id = :comment_id AND user_id = :user_id');
		$statement->execute(compact('comment_id', 'user_id'));
		$vote = $statement->fetch(PDO::FETCH_ASSOC);
		if ($vote === false) return null;
		return new Vote(...array_values($vote));
	}

	public function addVote(float $comment_id, float $user_id, bool $is_upvote): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO votes (comment_id, type, user_id) VALUES (:comment_id, :is_upvote, :user_id)');
		$statement->execute(compact('comment_id', 'user_id', 'is_upvote'));
	}

	public function removeVote(float $comment_id, float $user_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM votes WHERE comment_id = :comment_id AND user_id = :user_id');
		$statement->execute(compact('comment_id', 'user_id'));
	}
}
