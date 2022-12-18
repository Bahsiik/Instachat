<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\PostRepository;

class GetPostsBySearch {
	public function execute(string $input): array {
		return (new PostRepository())->getPostsBySearch($input);
	}
}