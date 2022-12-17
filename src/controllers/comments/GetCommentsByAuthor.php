<?php

namespace Controllers\comments;

use Models\CommentRepository;

class GetCommentsByAuthor {

	public function execute(float $author_id): array {
		$offset = (int)($_GET['offset'] ?? 0);
		return (new CommentRepository())->getCommentsByAuthor($author_id, $offset);
	}

}