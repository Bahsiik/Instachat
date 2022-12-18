<?php

namespace Controllers\comments;

use Controllers\Blocked\GetBlockedWords;
use Models\CommentRepository;
use function Lib\Utils\filter_blocked_posts;

class GetCommentsByAuthor {

	public function execute(float $author_id): array {
		global $connected_user;
		$offset = (int)($_GET['offsetComments'] ?? 0);
		$comments = (new CommentRepository())->getCommentsByAuthor($author_id, $offset);

		return filter_blocked_posts($connected_user, $comments);
	}

}