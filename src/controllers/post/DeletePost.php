<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\Post;
use Model\PostRepository;

class DeletePost {
	public function execute(Post|float $post): void {
		$post_id = $post instanceof Post ? $post->id : $post;
		(new PostRepository())->deletePost($post_id);
	}
}
