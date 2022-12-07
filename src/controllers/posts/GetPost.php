<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Post;
use Src\Models\PostRepository;

class GetPost {
	public function execute(int $id): Post {
		return (new PostRepository())->getPost($id);
	}
}
