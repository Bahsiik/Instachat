<?php

namespace Controllers;

require_once 'src/model/post.php';

use Application\Model\Blog\PostRepository;

class UpdateReaction {
    public function execute(int $id, int $reaction): void {
        (new PostRepository())->updateReaction($id, $reaction);
    }
}