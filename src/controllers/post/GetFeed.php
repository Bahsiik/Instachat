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
	public function execute(array $input): array {
		return (new PostRepository())->getFeed($input['user_id']);
	}
}
