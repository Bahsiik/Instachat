<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use DateTime;
use PDO;
use function array_values;

class Comment {
	public DateTime $createdAt;
	public bool $deleted;

	public function __construct(
		public float  $id,
		public string $content,
		public int    $upVotes,
		public int    $downVotes,
		public ?float $replyId,
		public float  $postId,
		string        $createdAt,
		public float  $authorId,
		int           $deleted,
	) {
		$this->createdAt = date_create_from_format('Y-m-d H:i:s', $createdAt);
		$this->deleted = $deleted === 1;
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
		$comment = $statement->fetch(PDO::FETCH_ASSOC);
		if ($comment === false) return null;
		return new Comment(...array_values($comment));
	}

	/**
	 * @param float $author_id
	 * @return Array<Comment>
	 */
	public function getCommentsByAuthor(float $author_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE author_id = :author_id AND deleted = FALSE');
		$statement->execute(compact('author_id'));
		$comments = [];
		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment(...array_values($comment));
		}

		return $comments;
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
			$comments[] = new Comment(...array_values($comment));
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
			$comments[] = new Comment(...array_values($comment));
		}

		return $comments;
	}

	/**
	 * @param float $comment_id
	 * @return Array<Comment>
	 */
	public function getCommentsReplyingRecursively(float $comment_id): array {
		$statement = $this->databaseConnection->prepare(<<<SQL
			WITH RECURSIVE
				cte AS 
				    (
				       SELECT * FROM instachat.comments WHERE id = :comment_id			
				       UNION ALL			
				       SELECT c.* FROM instachat.comments AS c INNER JOIN cte ON c.reply_id = cte.id
				    )
			SELECT * FROM cte;
			SQL
		);

		$statement->execute(compact('comment_id'));
		$comments = [];

		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment(...array_values($comment));
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
		$comments = [];

		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment(...array_values($comment));
		}

		return $comments;
	}
}
