<?php

namespace Controllers;

require_once 'src/model/post.php';

use Application\Model\Blog\PostRepository;
use Model\Post;

class GetPost
{
    public function execute(int $id): Post
    {
        return (new PostRepository())->getPost($id);
    }
}


