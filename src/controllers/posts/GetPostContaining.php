<?php

namespace Controllers\Posts;

require_once('src/models/Post.php');

use Models\Post;
use Models\PostRepository;

class GetPostContaining {
	/**
	 * @return Array<Post>
	 */
	public function execute(string $search): array {
		return (new PostRepository())->getPostContaining($search);
	}

}