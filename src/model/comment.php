<?php

namespace Model;

use Application\Lib\Database\DatabaseConnection;
use DateTime;
use PDO;

class Comment {
        private float $id; //autoincrement
        private string $content;
        private int $upvotes; //default 0
        private int $downvotes; //default 0
        private float $reply_id;
        private float $post_id;
        private DateTime $created_at; //autoincrement
        private float $author_id;
        private bool $deleted; //default 0
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
        $statement = $this->databaseConnection->prepare('UPDATE comments SET deleted = true WHERE id = :id');
        $statement->execute(compact('id'));
    }

    public function getCommentById(float $id): Comment|false {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE id = :id');
        $statement->execute(compact('id'));
        return $statement->fetchObject(Comment::class);
    }

    public function getCommentsByPost(float $post_id): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE post_id = :post_id AND deleted = false');
        $statement->execute(compact('post_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsByReply(float $reply_id): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE reply_id = :reply_id AND deleted = false');
        $statement->execute(compact('reply_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsByAuthor(float $author_id): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE author_id = :author_id AND deleted = false');
        $statement->execute(compact('author_id'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsByUpvotes(int $upvotes): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE upvotes = :upvotes AND deleted = false');
        $statement->execute(compact('upvotes'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsByDownvotes(int $downvotes): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE downvotes = :downvotes AND deleted = false');
        $statement->execute(compact('downvotes'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsByDate(DateTime $created_at): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE creation_date = :created_at AND deleted = false');
        $statement->execute(compact('created_at'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

    public function getCommentsContaining(string $content): array {
        $statement = $this->databaseConnection->prepare('SELECT * FROM comments WHERE content LIKE :content AND deleted = false');
        $statement->execute(compact('content'));
        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }
}