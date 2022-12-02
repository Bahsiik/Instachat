<?php

namespace Controllers\Post;

require_once('src/model/Post.php');

use Model\PostRepository;

class GetTrends
{
    public function execute(): array
    {
        return (new PostRepository())->getTrends();
    }
}