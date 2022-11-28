<?php

namespace Controllers;

require_once('src/model/post.php');

use Application\Model\Blog\PostRepository;

class AddPost {
    public function execute(string $content, int $author_id, string $photo, int $emotion, string $reaction): void {
        (new PostRepository())->addPost($content, $author_id, $photo, $emotion, $reaction);
    }
}
