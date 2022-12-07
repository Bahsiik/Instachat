<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Post;
use Src\Models\PostRepository;

class GetPostsByUser {
	/**
	 * @param int $id
	 * @return Array<Post>
	 */
	public function execute(int $id): array {
		return (new PostRepository())->getPostsByUser($id);
	}
}
