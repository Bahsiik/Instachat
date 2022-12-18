<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\PostRepository;
use function Lib\Utils\filter_blocked_posts;

/**
 * Class GetPostsBySearch is a controller that gets the posts containing a word
 */
class GetPostsBySearch {
	/**
	 * execute is the function that gets the posts containing a word
	 * @param string $input - the word to search
	 * @return array - the posts containing the word
	 */
	public function execute(string $input): array {
		global $connected_user;
		$offset = (int)($_GET['offsetSearchedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsBySearch($input, $offset);

		return filter_blocked_posts($connected_user, $posts);
	}
}