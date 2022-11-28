<?php

namespace Controllers;

require_once('src/model/post.php');

use Application\Model\Blog\PostRepository;
use Model\Post;

class DeletePost {
    public function execute(Post $post): void {
        (new PostRepository())->deletePost($post -> id);
    }
}
