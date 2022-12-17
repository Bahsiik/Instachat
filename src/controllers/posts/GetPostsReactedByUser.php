<?php

namespace Controllers\Posts;

use Models\PostRepository;

class GetPostsReactedByUser {
	public function execute($user_id) {
		return (new PostRepository())->getPostsReactedByUser($user_id);
	}

}