<?php
declare(strict_types=1);

namespace Controllers;

use Model\PostRepository;

class AddPost {
    public function execute(string $content, int $author_id, string $photo, int $emotion, string $reaction): void {
        (new PostRepository())->addPost($content, $author_id, $photo, $emotion, $reaction);
    }
}
