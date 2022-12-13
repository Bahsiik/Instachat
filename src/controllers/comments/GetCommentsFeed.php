<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;

class GetCommentsFeed {
	/**
	 * @return Comment[]
	 */
	public function execute(float $post_id): array {
		$offset = (int)($_GET['offset'] ?? 0);
		return (new CommentRepository())->getCommentsByPost($post_id, $offset);
	}
}
