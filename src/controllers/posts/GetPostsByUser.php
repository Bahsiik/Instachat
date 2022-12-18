<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Controllers\Blocked\GetBlockedWords;
use Models\Post;
use Models\PostRepository;

/**
 * Class GetPostsByUser is a controller that gets the posts of a user
 * @package Controllers\Posts
 */
class GetPostsByUser {
	/**
	 * @param float $id
	 * @return Array<Post>
	 */
	public function execute(float $id): array {
		global $connected_user;
		$posts = (new PostRepository())->getPostsByUser($id, (int)($_GET['offset'] ?? 0));
		$blocked_words = (new GetBlockedWords())->execute($connected_user);
		foreach ($posts as $post) {
				foreach ($blocked_words as $blocked_word) {
					if ($post->authorId !== $connected_user->id && mb_stripos(mb_strtolower($post->content), mb_strtolower($blocked_word->blockedWord)) !== false) {
						unset($posts[array_search($post, $posts, true)]);
					}
				}
			}
		return $posts;
	}
}
