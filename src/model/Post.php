<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use PDO;

enum Emotion: int {
	case LIKE = 1;
	case DISLIKE = 2;
	case LAUGH = 3;
	case HEART = 4;
	case SAD = 5;

	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::LIKE,
			2 => self::DISLIKE,
			3 => self::LAUGH,
			4 => self::HEART,
			default => self::SAD,
		};
	}
}

class Post {
	public DateTime $creation_date;
	public Emotion $emotion;

	public function __construct(
		public float   $id,
		public string  $content,
		public float   $author_id,
		public ?string $photo,
		int            $emotion,
		string         $creation_date,
		public bool    $deleted
	) {
		$this->creation_date = date_create_from_format('U', $creation_date);
		$this->emotion = Emotion::fromInt($emotion);
	}
}

class PostRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function addPost(string $content, int $author_id, string $photo, int $emotion, string $reaction): void {
		$statement = $this->databaseConnection->prepare('INSERT INTO posts (content, author_id, photo, emotion) VALUES (:content, :author_id, :photo, :emotion)');
		$statement->execute(compact('content', 'author_id', 'photo', 'emotion'));
	}

	public function deletePost(float $id): void {
		$statement = $this->databaseConnection->prepare('UPDATE posts SET deleted = true WHERE id = :id');
		$statement->execute(compact('id'));
	}

	public function getFeed(float $user_id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE author_id IN (SELECT requested_id FROM friends WHERE requester_id = :author_id AND accepted = true) ORDER BY creation_date DESC');
		$statement->execute(compact('user_id'));
		return $statement->fetchObject(Post::class);
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

	public function updateEmotion(float $id, Emotion $emotion): void {
		$statement = $this->databaseConnection->prepare('UPDATE posts SET emotion = :emotion WHERE id = :id');
		$statement->execute(['id' => $id, 'emotion' => $emotion->value]);
	}
}