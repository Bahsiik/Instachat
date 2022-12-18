<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\PostRepository;
use function Lib\Utils\filter_blocked_posts;

class GetPostsBySearch {
	public function execute(string $input): array {
		global $connected_user;
		$offset = (int)($_GET['offsetSearchedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsBySearch($input, $offset);

		return filter_blocked_posts($connected_user, $posts);
	}
}