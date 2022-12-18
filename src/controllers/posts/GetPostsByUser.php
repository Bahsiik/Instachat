<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Controllers\Blocked\GetBlockedWords;
use Models\Post;
use Models\PostRepository;
use function Lib\Utils\filter_blocked_posts;

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
		global $connected_user;
		$posts = (new PostRepository())->getPostsByUser($id, (int)($_GET['offset'] ?? 0));
		return filter_blocked_posts($connected_user, $posts);
	}
}
