<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once('src/models/Post.php');

use Models\Post;
use Models\PostRepository;
use Models\User;

class GetFeed {
	/**
	 * @return Array<Post>
	 */
	public function execute(User $user): array {
		return (new PostRepository())->getFeed($user->id, (int)($_GET['offset'] ?? 0));
	}
}
