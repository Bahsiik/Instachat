<?php

namespace Controllers\Posts;

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;
use Controllers\Blocked\GetUsersThatBlocked;
use Models\PostRepository;
use function Lib\Utils\filter_blocked_posts;

class GetPostsReactedByUser {
	public function execute($user_id) {
		global $connected_user;
		$offset = (int)($_GET['offsetReactedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsReactedByUser($user_id, $offset);

		return filter_blocked_posts($connected_user, $posts);
	}

}