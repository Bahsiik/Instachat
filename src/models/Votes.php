<?php
declare(strict_types=1);

use Database\DatabaseConnection;

/**
 * Class Vote is a class that represents a vote
 * @package Models
 */
class Vote {
	public bool $isUpvote;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct(
		public float $commentId,
		int          $type,
		public float $userId,
	) {
		$this->isUpvote = $type === 1;
	}
}

/**
 * Class VoteRepository is a class that represents a vote repository
 * @package Models
 */
class VotesRepository {
	private PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * getVotesByCommentId is the function that gets the votes by comment id
	 * @param float $comment_id - the id of the comment
	 * @return Array<Vote> - the votes
	 */
	public function getVotesByCommentId(float $comment_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM votes WHERE comment_id = :comment_id');
		$statement->execute(compact('comment_id'));
		$votes = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array_map(static fn($vote) => new Vote(...array_values($vote)), $votes);
	}

	/**
	 * getVoteByUserIdAndCommentId is the function that gets the vote by user id and comment id
	 * @param float $comment_id - the id of the comment
	 * @param float $user_id - the id of the user
	 * @return ?Vote - the vote or null if it doesn't exist
	 */
	public function getVoteByUserIdAndCommentId(float $comment_id, float $user_id): ?Vote {
		$statement = $this->databaseConnection->prepare('SELECT * FROM votes WHERE comment_id = :comment_id AND user_id = :user_id');
		$statement->execute(compact('comment_id', 'user_id'));
		$vote = $statement->fetch(PDO::FETCH_ASSOC);
		if ($vote === false) return null;
		return new Vote(...array_values($vote));
	}

	/**
	 * addVote is the function that adds a vote
	 * @param float $comment_id - the id of the comment
	 * @param float $user_id - the id of the user
	 * @param bool $is_upvote - the type of the vote
	 * @return void
	 */
	public function addVote(float $comment_id, float $user_id, bool $is_upvote): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO votes (comment_id, type, user_id) VALUES (:comment_id, :is_upvote, :user_id)');
		$statement->execute(compact('comment_id', 'user_id', 'is_upvote'));
	}

	/**
	 * remove is the function that removes a vote
	 * @param float $comment_id - the id of the comment
	 * @param float $user_id - the id of the user
	 * @return void
	 */
	public function removeVote(float $comment_id, float $user_id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM votes WHERE comment_id = :comment_id AND user_id = :user_id');
		$statement->execute(compact('comment_id', 'user_id'));
	}
}
