<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once('src/models/Post.php');

use Models\PostRepository;

class GetTrends {
	public function execute(): array {
		return (new PostRepository())->getTrends();
	}
}
