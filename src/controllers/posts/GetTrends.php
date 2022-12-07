<?php

namespace Src\Controllers\Post;

use Src\Models\PostRepository;

class GetTrends {
	public function execute(): array {
		return (new PostRepository())->getTrends();
	}
}
