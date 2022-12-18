<?php

namespace Controllers\comments;

use Controllers\Blocked\GetBlockedWords;
use Models\CommentRepository;

class GetCommentsByAuthor {

	public function execute(float $author_id): array {
		global $connected_user;
		$offset = (int)($_GET['offsetComments'] ?? 0);
		$comments = (new CommentRepository())->getCommentsByAuthor($author_id, $offset);
		$blocked_words = (new GetBlockedWords())->execute($connected_user);
		foreach ($comments as $comment) {
			foreach ($blocked_words as $blocked_word) {
				if ($comment->authorId !== $connected_user->id && mb_stripos(mb_strtolower($comment->content), mb_strtolower($blocked_word->blockedWord)) !== false) {
					unset($comments[array_search($comment, $comments, true)]);
				}
			}
		}
		return $comments;
	}

}