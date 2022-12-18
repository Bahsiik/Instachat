<?php

namespace Controllers\Posts;

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;
use Models\PostRepository;

class GetPostsReactedByUser {
	public function execute($user_id) {
		global $connected_user;
		$offset = (int)($_GET['offsetReactedPosts'] ?? 0);
		$posts = (new PostRepository())->getPostsReactedByUser($user_id, $offset);
		$blocked_words = (new GetBlockedWords())->execute($connected_user);
		foreach ($posts as $post) {
			foreach ($blocked_words as $blocked_word) {
				if ($post->authorId !== $connected_user->id && mb_stripos(mb_strtolower($post->content), mb_strtolower($blocked_word->blockedWord)) !== false) {
					unset($posts[array_search($post, $posts, true)]);
				}
			}
		}
		$blocked_users = (new GetBlockedUsers())->execute($connected_user);
		foreach ($posts as $post) {
			foreach ($blocked_users as $blocked_user) {
				if ($post->authorId === $blocked_user->blockedId) {
					unset($posts[array_search($post, $posts, true)]);
				}
			}
		}
		return $posts;
	}

}