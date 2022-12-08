<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;

class Comment {
	public DateTime $created_at;

	public function __construct(
		public float  $author_id,
		public string $content,
		public bool   $deleted,
		public int    $downvotes,
		public float  $id,
		public float  $post_id,
		public float  $reply_id,
		public int    $upvotes,
		string        $created_at
	) {
		$this->created_at = date_create_from_format('Y-m-d H:i:s', $created_at);
	}
}

class CommentRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function addComment(string $content, float $reply_id, float $post_id, float $author_id): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO comments (content, reply_id, post_id, author_id) VALUES (:content, :reply_id, :post_id, :author_id)');
		$statement->execute(compact('content', 'reply_id', 'post_id', 'author_id'));
	}

	public function deleteCommentById(float $id): void {
		$statement = $this->databaseConnection->prepare('UPDATE comments SET deleted = TRUE WHERE id = :id');
		$statement->execute(compact('id'));
	}

	public function getCommentById(float $id): ?Comment {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE id = :id');
		$statement->execute(compact('id'));
		return $statement->fetchObject(Comment::class) ?: null;
	}

	/**
	 * @param float $author_id
	 * @return Array<Comment>
	 */
	public function getCommentsByAuthor(float $author_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE author_id = :author_id AND deleted = FALSE');
		$statement->execute(compact('author_id'));
		return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
	}

	/**
	 * @param float $post_id
	 * @return Array<Comment>
	 */
	public function getCommentsByPost(float $post_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE post_id = :post_id AND deleted = FALSE');
		$statement->execute(compact('post_id'));
		$comments = [];

		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Friend(...array_values($comment));
		}

		return $comments;
	}

	/**
	 * @param float $reply_id
	 * @return Array<Comment>
	 */
	public function getCommentsByReply(float $reply_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE reply_id = :reply_id AND deleted = FALSE');
		$statement->execute(compact('reply_id'));
		$comments = [];

		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Friend(...array_values($comment));
		}

		return $comments;
	}

	/**
	 * @param string $content
	 * @return Array<Comment>
	 */
	public function getCommentsContaining(string $content): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE content LIKE :content AND deleted = FALSE');
		$statement->execute(compact('content'));
		return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
	}
}
