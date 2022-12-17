<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\Post;
use Models\PostRepository;

/**
 * Class GetPostsByUser is a controller that gets the posts of a user
 * @package Controllers\Posts
 */
class GetPostsByUser {
	/**
	 * @param float $id
	 * @return Array<Post>
	 */
	public function execute(float $id): array {
		return (new PostRepository())->getPostsByUser($id, (int)($_GET['offset'] ?? 0));
	}
}
