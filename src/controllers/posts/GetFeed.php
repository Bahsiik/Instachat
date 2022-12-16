<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once('src/models/Post.php');

use Controllers\Blocked\GetBlockedWords;
use Models\Post;
use Models\PostRepository;
use Models\User;

class GetFeed {
	/**
	 * @return Array<Post>
	 */
	public function execute(User $user): array {
		$posts = (new PostRepository())->getFeed($user->id, (int)($_GET['offset'] ?? 0));

		$blocked_words = (new GetBlockedWords())->execute($user);

		foreach ($posts as $post) {
			foreach ($blocked_words as $blocked_word) {
				if (mb_stripos(mb_strtolower($post->content), mb_strtolower($blocked_word->blockedWord)) !== false && $post->authorId !== $user->id) {
					unset($posts[array_search($post, $posts)]);
				}
			}
		}

		return $posts;
	}
}
