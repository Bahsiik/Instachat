<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\PostRepository;
use function Lib\Utils\filterBlockedPosts;

class GetPostsBySearch {
	public function execute(string $input): array {
		global $connected_user;
		$offset = (int)($_GET['offsetSearchedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsBySearch($input, $offset);

		return filterBlockedPosts($connected_user, $posts);
	}
}