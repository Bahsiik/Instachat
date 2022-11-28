<?php

namespace Controllers;

require_once 'src/model/post.php';

use Application\Model\Blog\PostRepository;

class UpdateEmotion {
    public function execute(int $id, string $emotion): void {
        (new PostRepository())->updateEmotion($id, $emotion);
    }
}