<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\Post;
use Models\PostRepository;

class GetPost {
	public function execute(int $id): Post {
		return (new PostRepository())->getPost($id);
	}
}
