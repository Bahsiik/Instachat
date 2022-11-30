<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\Post;
use Model\PostRepository;

class GetFeed {
	/**
	 * @param int $id
	 * @return Array<Post>
	 */
	public function execute(int $id): array {
		return (new PostRepository())->getFeed($id);
	}
}