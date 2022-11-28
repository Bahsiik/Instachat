<?php

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use DateTime;
use Lib\Database\DatabaseConnection;

class Post {
    public int $id;
    public string $content;
    public int $author_id;
    public DateTime $creation_date;
    public string $photo;
    public int $emotion;
    public string $reaction;
}

class PostRepository {
    public DatabaseConnection $databaseConnection;

    public function __construct() {
        $this->databaseConnection = (new DatabaseConnection())->getConnection();
    }

    public function addPost(string $content, int $author_id, string $photo, int $emotion, string $reaction): void {
        $statement = $this->databaseConnection->prepare('INSERT INTO posts (content, author_id, photo, emotion) VALUES (:content, :author_id, :creation_date, :photo, :emotion)');
        $statement->execute(compact('content', 'author_id', 'photo', 'emotion'));
    }

    public function deletePost(int $id): void {
        $statement = $this->databaseConnection->prepare('DELETE FROM posts WHERE id = :id');
        $statement->execute(compact('id'));
    }

    public function getPost(int $id): Post {
        $statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE id = :id');
        $statement->execute(compact('id'));
        return $statement->fetchObject(Post::class);
    }

    public function getFeed(int $user_id): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE author_id IN (SELECT requested_id FROM friends WHERE requester_id = :author_id AND accepted = true) ORDER BY creation_date DESC');
        $statement->execute(compact('user_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Post::class);
    }


    public function getPostsByUser(int $author_id): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM posts WHERE author_id = :author_id ORDER BY creation_date DESC');
        $statement->execute(compact('author_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Post::class);
    }

    public function updateEmotion(int $id, int $emotion): void {
        $statement = $this->databaseConnection->prepare('UPDATE posts SET emotion = :emotion WHERE id = :id');
        $statement->execute(compact('id', 'emotion'));
    }

    public function updateReaction(int $id, string $reaction): void {
        $statement = $this->databaseConnection->prepare('UPDATE reactions SET emoji = :reaction WHERE id = :id');
        $statement->execute(compact('id', 'reaction'));
    }
}