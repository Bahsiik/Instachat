<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\Post;
use Models\PostRepository;

class GetPostsByUser {
	/**
	 * @param float $id
	 * @return Array<Post>
	 */
	public function execute(float $id): array {
		return (new PostRepository())->getPostsByUser($id);
	}
}
