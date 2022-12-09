<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\Post;
use Models\PostRepository;

class DeletePost {
	public function execute(Post|float $post): void {
		$post_id = $post instanceof Post ? $post->id : $post;
		(new PostRepository())->deletePost($post_id);
	}
}
