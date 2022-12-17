<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once 'src/models/Post.php';

use Controllers\Blocked\GetBlockedWords;
use Models\PostRepository;
use Models\User;

/**
 * Class GetFeed is a controller that gets the feed of a user
 * @package Controllers\Posts
 */
class GetFeed {
	/**
	 * execute is the function that gets the feed of a user
	 * @param User $user - the user to get the feed of
	 * @return array - the feed of the user
	 */
	public function execute(User $user): array {
		$posts = (new PostRepository())->getFeed($user->id, (int)($_GET['offset'] ?? 0));

		$blocked_words = (new GetBlockedWords())->execute($user);

		foreach ($posts as $post) {
			foreach ($blocked_words as $blocked_word) {
				if ($post->authorId !== $user->id && mb_stripos(mb_strtolower($post->content), mb_strtolower($blocked_word->blockedWord)) !== false) {
					unset($posts[array_search($post, $posts, true)]);
				}
			}
		}

		return $posts;
	}
}
