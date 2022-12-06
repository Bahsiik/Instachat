<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');
require_once('src/lib/Blob.php');

use Database\DatabaseConnection;
use DateTime;
use Exception;
use PDO;
use Utils\Blob;

enum Emotion: int {
	case HAPPY = 1;
	case FUNNY = 2;
	case DOUBTFUL = 3;
	case SAD = 4;
	case ANGRY = 5;
	case LOVE = 6;

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

class Post {
	public DateTime $creation_date;
	public Emotion $emotion;
	public ?Blob $image;

	public function __construct(public float $author_id, public ?string $content, public int $deleted, public float $id, string $creation_date, int $emotion, ?string $image) {
		$this->creation_date = date_create_from_format('Y-m-d H:i:s', $creation_date);
		$this->emotion = Emotion::fromInt($emotion);
		if ($image !== null) {
			$this->image = new Blob($image);
		}
	}
}

class PostRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function addPost(string $content, int $author_id, ?string $photo, int $emotion): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO posts (content, author_id, photo, emotion) VALUES (:content, :author_id, :photo, :emotion)');
		$statement->execute(compact('content', 'author_id', 'photo', 'emotion'));
	}

	public function deletePost(float $id): void {
		$statement = $this->databaseConnection->prepare('UPDATE posts SET deleted = true WHERE id = :id');
		$statement->execute(compact('id'));
	}

	public function getFeed(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT p.*
            FROM posts p
                     JOIN friends f
                          ON (p.author_id = f.requested_id OR p.author_id = f.requester_id)
            WHERE ((f.requested_id = :user_id OR f.requester_id = :user_id) OR p.author_id = :user_id)
              AND f.accepted = 1 AND p.deleted = 0 ORDER BY p.creation_date DESC LIMIT 5');
		$statement->execute(compact('user_id'));
		$posts = [];

		try {
			while ($post = $statement->fetch(PDO::FETCH_ASSOC)) {
				$posts[] = new Post($post['author_id'], $post['content'], $post['deleted'], $post['id'], $post['creation_date'], $post['emotion'], $post['photo']);
			}
		} catch (Exception) {
			return [];
		}
		return $posts;
	}

	public function getPost(float $id): Post {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE id = :id');
		$statement->execute(compact('id'));
		return $statement->fetchObject(Post::class);
	}

	public function getPostContaining(string $content): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE content LIKE :content ORDER BY creation_date DESC');
		$statement->execute(compact('content'));
		return $statement->fetchObject(Post::class);
	}

	public function getPostsByUser(float $author_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE author_id = :author_id ORDER BY creation_date DESC');
		$statement->execute(compact('author_id'));
		return $statement->fetchObject(Post::class);
	}

	public function getTrends(): array {
		$statement = $this->databaseConnection->prepare('SELECT content FROM posts WHERE creation_date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND deleted = false');
		$statement->execute();
		$posts = $statement->fetchAll(PDO::FETCH_COLUMN);
		$words = [];
		foreach ($posts as $post) {
			$uniqueWords = array_unique(explode(' ', $post));
			$words = array_merge($words, $uniqueWords);
		}
		$words = array_filter($words, fn($word) => strlen($word) > 3);
		$words = array_map('strtolower', $words);
		$words = array_map('ucfirst', $words);
		$words = array_count_values($words);
		arsort($words);
		return array_slice($words, 0, 10);
	}

	public function updateEmotion(float $id, Emotion $emotion): void {
		$statement = $this->databaseConnection->prepare('UPDATE posts SET emotion = :emotion WHERE id = :id');
		$statement->execute(['id' => $id, 'emotion' => $emotion->value]);
	}
}
