<?php
declare(strict_types=1);

namespace Controllers\Post;

require_once('src/model/Post.php');

use Model\Post;
use Model\PostRepository;

class GetFeed {
	/**
	 * @return Array<Post>
	 */
	public function execute(): array {
        $user_id = $_SESSION['user_id'];
		return (new PostRepository())->getFeed($user_id);
	}
}