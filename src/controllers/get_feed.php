<?php

namespace Controllers;

require_once 'src/model/post.php';

use Application\Model\Blog\PostRepository;
use Model\Post;

class GetFeed {
    public function execute(int $id): Post {
        return (new PostRepository())->getFeed($id);
    }
}