<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Post;
use Src\Models\PostRepository;

class GetFeed {
	/**
	 * @return Array<Post>
	 */
	public function execute(array $input): array {
		return (new PostRepository())->getFeed($input['user_id']);
	}
}
