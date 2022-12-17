<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use DateTime;
use PDO;
use function array_values;

/**
 * Class Blocked is a class that represents a blocked user
 * @package Models
 */
class Comment {
	public DateTime $createdAt;
	public bool $deleted;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct(
		public float  $id,
		public string $content,
		public ?float $replyId,
		public float  $postId,
		string        $createdAt,
		public float  $authorId,
		int           $deleted,
	) {
		$this->createdAt = date_create_from_format('Y-m-d H:i:s', $createdAt);
		$this->deleted = $deleted === 1;
	}

	/**
	 * getLink is the function that gets the link of the comment
	 * @return string - the link of the comment
	 */
	public function getLink(): string {
		return "/post?id=$this->postId#comment-$this->id";
	}
}

/**
 * Class CommentRepository is a class that represents a comment repository
 * @package Models
 */
class CommentRepository {
	public PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * addComment is the function that adds a comment
	 * @param string $content - the content of the comment
	 * @param float $post_id - the id of the post
	 * @param float $author_id - the id of the author
	 * @param ?float $reply_id - the id of the comment that is replied
	 * @return void
	 */
	public function addComment(string $content, float $post_id, float $author_id, ?float $reply_id = null): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO comments (author_id, content, post_id, reply_id) VALUES (:author_id, :content, :post_id, :reply_id)');
		$statement->execute(compact('author_id', 'content', 'post_id', 'reply_id'));
	}

	/**
	 * deleteCommentById is the function that deletes a comment by id
	 * @param float $id - the id of the comment
	 * @return void
	 */
	public function deleteCommentById(float $id): void {
		$statement = $this->databaseConnection->prepare('UPDATE comments SET deleted = TRUE WHERE id = :id');
		$statement->execute(compact('id'));
	}

	/**
	 * getCommentById is the function that gets a comment by id
	 * @param float $id - the id of the comment
	 * @return Comment|null - the comment or null if it doesn't exist
	 */
	public function getCommentById(float $id): ?Comment {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE id = :id');
		$statement->execute(compact('id'));
		$comment = $statement->fetch(PDO::FETCH_ASSOC);
		if ($comment === false) return null;
		return new Comment(...array_values($comment));
	}

	/**
	 * getCommentsByAuthor is the function that gets the comments by author
	 * @param float $author_id - the id of the author
	 * @return Array<Comment> - the comments
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
	 * getCommentsByPost is the function that gets the comments by post
	 * @param float $post_id - the id of the post
	 * @param int $offset - the offset of the comments
	 * @return Array<Comment> - the comments
	 */
	public function getCommentsByPost(float $post_id, int $offset): array {
		$statement = $this->databaseConnection->prepare("SELECT * FROM comments WHERE post_id = :post_id AND deleted = FALSE ORDER BY creation_date DESC LIMIT 5 OFFSET $offset");
		$statement->execute(compact('post_id'));
		$comments = [];

		while ($comment = $statement->fetch(PDO::FETCH_ASSOC)) {
			$comments[] = new Comment(...array_values($comment));
		}

		return $comments;
	}

	/**
	 * countCommentsByPost is the function that counts the comments by post
	 * @param float $post_id - the id of the post
	 * @return int - the number of comments
	 */
	public function countCommentsByPost(float $post_id): int {
		$statement = $this->databaseConnection->prepare('SELECT COUNT(*) FROM comments WHERE post_id = :post_id AND deleted = FALSE');
		$statement->execute(compact('post_id'));
		return $statement->fetchColumn();
	}

	/**
	 * getCommentsByReply is the function that gets the comments by reply
	 * @param float $reply_id - the id of the reply
	 * @return Array<Comment> - the comments
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
	 * getCommentsReplyingRecursively is the function that gets the comments replying recursively
	 * @param float $comment_id - the id of the comment
	 * @return Array<Comment> - the comments
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
			SELECT * FROM cte WHERE deleted = FALSE AND id != :comment_id
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
	 * commentHasReply is the function that checks if a comment has a reply
	 * @param float $comment_id - the id of the comment
	 * @return bool - true if the comment has a reply, false otherwise
	 */
	public function commentHasReply(float $comment_id): bool {
		$statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE reply_id = :comment_id AND deleted = FALSE');
		$statement->execute(compact('comment_id'));
		return $statement->fetch(PDO::FETCH_ASSOC) !== false;
	}

	/**
	 * getCommentsContaining is the function that gets the comments containing a string
	 * @param string $content - the string
	 * @return Array<Comment> - the comments
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
