<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;
use Controllers\Blocked\GetUsersThatBlocked;
use Models\PostRepository;
use function Lib\Utils\filter_blocked_posts;

/**
 * Class GetPostsReactedByUser is a controller that gets the posts reacted by a user
 */
class GetPostsReactedByUser {
	/**
	 * execute is the function that gets the posts reacted by a user
	 * @param $user_id - the id of the user
	 * @return array - the posts reacted by the user
	 */
	public function execute($user_id): array {
		global $connected_user;
		$offset = (int)($_GET['offsetReactedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsReactedByUser($user_id, $offset);

		return filter_blocked_posts($connected_user, $posts);
	}

}