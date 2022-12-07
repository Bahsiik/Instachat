<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Post;
use Src\Models\PostRepository;

class DeletePost {
	public function execute(Post|float $post): void {
		$post_id = $post instanceof Post ? $post->id : $post;
		(new PostRepository())->deletePost($post_id);
	}
}
