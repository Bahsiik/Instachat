<?php
declare(strict_types=1);

namespace Models;

require_once('src/lib/DatabaseConnection.php');
require_once('src/lib/Blob.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;
use Utils\Blob;

/**
 * Enum Emotion is used to represent the emotions that the user can put to his post.
 */
enum Emotion: int {
	case HAPPY = 1;
	case FUNNY = 2;
	case DOUBTFUL = 3;
	case SAD = 4;
	case ANGRY = 5;
	case LOVE = 6;

	/**
	 * fromInt returns the Emotion corresponding to the given int.
	 * @param int $value - The int to convert.
	 * @return static - The Emotion corresponding to the given int.
	 */
	public static function fromInt(int $value): self {
		return match ($value) {
			default => self::HAPPY,
			2 => self::FUNNY,
			3 => self::DOUBTFUL,
			4 => self::SAD,
			5 => self::ANGRY,
			6 => self::LOVE,
		};
	}

	/**
	 * display returns the emoji corresponding to the Emotion.
	 * @return string - The emoji corresponding to the Emotion.
	 */
	public function display(): string {
		return match ($this) {
			self::HAPPY => '😁',
			self::FUNNY => '🤣',
			self::DOUBTFUL => '🤔',
			self::SAD => '😭',
			self::ANGRY => '😡',
			self::LOVE => '😍',
		};
	}
}

/**
 * Class Post represents a post in the database.
 */
class Post {
	public DateTime $creationDate;
	public Emotion $emotion;
	public ?Blob $image;

	/**
	 * Post constructor.
	 * @param float $id - The id of the post.
	 * @param string|null $content - The content of the post.
	 * @param float $authorId - The id of the author of the post.
	 * @param string $creationDate - The creation date of the post.
	 * @param string|null $image - The image of the post.
	 * @param int $emotion - The emotion of the post.
	 * @param int $deleted - The deleted status of the post.
	 */
	public function __construct(
		public float   $id,
		public ?string $content,
		public float   $authorId,
		string         $creationDate,
		?string        $image,
		int            $emotion,
		public int     $deleted,
	) {
		$this->creationDate = date_create_from_format('Y-m-d H:i:s', $creationDate);
		$this->emotion = Emotion::fromInt($emotion);
		if ($image !== null) {
			$this->image = new Blob($image);
		}
	}
}

/**
 * Class PostRepository is used to interact with the posts in the database.
 */
class PostRepository {
	public PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * addPost creates a new post in the database.
	 * @param string $content - The content of the post.
	 * @param float $author_id - The id of the author of the post.
	 * @param string|null $photo - The photo of the post.
	 * @param int $emotion - The emotion of the post.
	 * @return void - This function does not return anything.
	 */
	public function addPost(string $content, float $author_id, ?string $photo, int $emotion): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO posts (content, author_id, photo, emotion) VALUES (:content, :author_id, :photo, :emotion)');
		$statement->execute(compact('content', 'author_id', 'photo', 'emotion'));
	}

	/**
	 * deletePost deletes the post with the given id.
	 * @param float $id - The id of the post to delete.
	 * @return void - This function does not return anything.
	 */
	public function deletePost(float $id): void {
		$statement = $this->databaseConnection->prepare('UPDATE posts SET deleted = TRUE WHERE id = :id');
		$statement->execute(compact('id'));
	}

	/**
	 * getFeed returns the posts of the users that the given user follows.
	 * @param float $user_id - The id of the user.
	 * @param int $offset - The offset of the posts.
	 * @return Array<Post> - The posts of the users that the given user follows.
	 */
	public function getFeed(float $user_id, int $offset): array {
		$statement = $this->databaseConnection->prepare("SELECT DISTINCT p.*
		FROM instachat.posts p
		         LEFT JOIN (SELECT f.requester_id, f.requested_id, f.accepted
		                    FROM instachat.friends f
		                    WHERE f.requested_id = :user_id
		                       OR f.requester_id = :user_id) f ON p.author_id = f.requester_id OR p.author_id = f.requested_id
		WHERE p.deleted = false
		  AND (p.author_id = :user_id
		    OR (f.accepted = TRUE AND f.requested_id = :user_id)
		    OR (f.accepted = TRUE AND f.requester_id = :user_id))
		ORDER BY p.creation_date DESC
		LIMIT $offset, 5");
		$statement->execute(compact('user_id', 'offset'));
		$posts = [];

		while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
			$posts[] = new Post(...array_values($post));
		}

		return $posts;
	}


	/**
	 * getPost returns the posts of the given user.
	 * @param float $id
	 * @return Post - The posts of the given user.
	 */
	public function getPost(float $id): Post {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE id = :id');
		$statement->execute(compact('id'));
		$post = $statement->fetch(PDO::FETCH_ASSOC);
		return new Post(...array_values($post));
	}

	/**
	 * getPostsByUser returns the posts of the given user.
	 * @param float $author_id - The id of the user.
	 * @param int $offset - The offset of the posts.
	 * @return array - The posts of the given user.
	 */
	public function getPostsByUser(float $author_id, int $offset): array {
		$statement = $this->databaseConnection->prepare("SELECT * FROM posts WHERE author_id = :author_id AND deleted = FALSE ORDER BY creation_date DESC LIMIT $offset, 5");
		$statement->execute(compact('author_id'));
		$posts = [];

		while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
			$posts[] = new Post(...array_values($post));
		}

		return $posts;
	}

	/**
	 * getTrends returns the trending posts.
	 * @param array $blocked_words - The blocked words.
	 * @return array - The trending posts.
	 */
	public function getTrends(array $blocked_words): array {
		$statement = $this->databaseConnection->prepare('SELECT content FROM posts WHERE creation_date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND deleted = FALSE');
		$statement->execute();
		$posts = $statement->fetchAll(PDO::FETCH_COLUMN);
		$words = [];
		foreach ($posts as $post) {
			$unique_words = array_filter(array_unique(preg_split('/[\s,]+/', $post)), fn($word) => preg_match('/^[^A-Za-z0-9]+$/', $word) === 0);
			$words = array_merge($words, $unique_words);
		}
		$words = array_filter($words, fn($word) => strlen($word) > 3);
		$words = array_map(fn($word) => strtolower($word), $words);
		$words = array_diff($words, $blocked_words);
		$words = array_map('ucfirst', $words);
		$words = array_count_values($words);
		arsort($words);
		return array_slice($words, 0, 10);
	}


	/**
	 * getPostContaining returns the posts containing the given word.
	 * @param string $content - The word to search for.
	 * @return array - The posts containing the given word.
	 */
	public function getPostContaining(string $content): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE content LIKE :content AND deleted = FALSE AND creation_date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY creation_date DESC');
		$statement->execute(['content' => "%$content%"]);
		$posts = [];

		while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
			$words = preg_split('/[\s,]+/', $post['content']);
			$words = array_map(fn($word) => strtolower($word), $words);
			if (in_array(strtolower($content), $words)) {
				$posts[] = new Post(...array_values($post));
			}
		}

		return $posts;
	}

	/**
	 * getPostsReactedByUser returns the posts reacted by the given user.
	 * @param float $user_id - The id of the user.
	 * @param int $offset - The offset of the posts.
	 * @return array - The posts reacted by the given user.
	 */
	public function getPostsReactedByUser(float $user_id, int $offset): array {
		$statement = $this->databaseConnection->prepare("SELECT DISTINCT p.* FROM posts p INNER JOIN reactions r ON p.id = r.post_id INNER JOIN reaction_users ru ON r.id = ru.reaction_id WHERE ru.user_id = :user_id ORDER BY p.creation_date DESC LIMIT $offset, 5");
		$statement->execute(compact('user_id'));
		$posts = [];

		while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
			$posts[] = new Post(...array_values($post));
		}

		return $posts;
	}

	/**
	 * getPostsBySearch returns the posts containing the given word.
	 * @param string $search - The word to search for.
	 * @return array - The posts containing the given word.
	 */
	public function getPostsBySearch(string $search): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE content LIKE :content AND deleted = FALSE ORDER BY creation_date DESC');
		$statement->execute(['content' => "%$search%"]);
		$posts = [];

		while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
			$posts[] = new Post(...array_values($post));
		}

		return $posts;
	}
}
