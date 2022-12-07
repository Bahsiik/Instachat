<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\Post;
use Model\PostRepository;

class GetPost {
	public function execute(int $id): Post {
		return (new PostRepository())->getPost($id);
	}
}


