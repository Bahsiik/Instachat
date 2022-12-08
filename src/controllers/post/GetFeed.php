<?php
declare(strict_types=1);

namespace Controllers\Post;

require_once('src/model/Post.php');

use Model\Post;
use Model\PostRepository;
use Model\User;

class GetFeed {
	/**
	 * @return Array<Post>
	 */
	public function execute(User $user): array {
		return (new PostRepository())->getFeed($user->id, (int)($_GET['offset'] ?? 0));
	}
}
