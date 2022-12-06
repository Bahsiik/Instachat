<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\Post;
use Model\PostRepository;

class DeletePost {
	public function execute(Post $post): void {
		(new PostRepository())->deletePost($post->id);
	}
}
